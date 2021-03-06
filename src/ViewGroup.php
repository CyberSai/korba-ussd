<?php

/**
 * Class ViewGroup at src/ViewGroup.php.
 * File containing ViewGroup class
 * @api
 * @author Isaac Adzah Sai <isaacsai030@gmail.com>
 * @version 2.5.2
 */
namespace Korba;

/**
 * Class ViewGroup groups view for easy access.
 * A class to group view and return one given the index.
 * @package Korba
 */
class ViewGroup
{
    /** @var View $views Array of views to group */
    private $views;

    /**
     * ViewGroup constructor.
     * Accepts and stores views
     * @param View[] $views
     */
    public function __construct($views)
    {
        $this->views = $views;
    }

    /**
     * ViewGroup public function getView.
     * Return the view for a given index
     * @param int $page
     * @return View
     */
    public function getView($page)
    {
        return $this->views[$page - 1];
    }
}