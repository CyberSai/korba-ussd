<?php


namespace Korba;


final class Services extends Collection
{

    /**
     * Services constructor.
     * @param VerifyAccounts $accounts_worker
     * @param VerifyPayment $payment_worker
     * @param array $available
     */
    public function __construct($payment_worker, $accounts_worker = null, $available = [false, true, true, true, true])
    {
        if ($accounts_worker != null) {
            $accounts_worker->setViews([new AirtimeAccMomo(), new AirtimeAccMomoError()]);
        }

        $collection = [
            'korba_menu' => new Menu('non-registered',...$available),
            'korba_menu_r' => new Menu('registered',...$available),
            'korba_sub_menu' => new SubMenu(...$available),
            'korba_airtime_net_num' => new AirtimeNetNum(),
            'korba_airtime_num' => new AirtimeNumber(),
            'korba_airtime_num_confirm' => new AirtimeConfirm(),
            'korba_airtime_amount' => new VerifyConfirmed([new AirtimeAmount(), new Error()]),
            'korba_airtime_confirmation' => new AirtimeVerifyAmount($accounts_worker),
            'korba_airtime_pay' => new VerifyConfirmed([new AirtimePayFrom(), new Error()]),
            'korba_airtime_acc_momo' => $accounts_worker,
            'korba_airtime_pin' => new AirtimePin($accounts_worker),
            'korba_airtime_vod' => new Voucher('korba_airtime_auth'),
            'korba_airtime_auth' => $payment_worker
        ];
        parent::__construct($collection);
    }
}