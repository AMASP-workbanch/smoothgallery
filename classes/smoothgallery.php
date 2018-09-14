<?php

/**
 *  Smooth Gallery
 *
 *  Private L* 4.0 project
 *
 *  @package    LEPTON-CMS modules
 *  @module     Smooth Gallery
 *  @author     ToS, Matthias Gallas, Dietrich Roland Pehlke (last)
 *  @license    GNU General Public License
 *
 */
 
 class smoothgallery extends LEPTON_abstract
 {
    /**
     *  The own singelton instance.
     *  @type   instance
     */
    static $instance;
    
    public $bAlreadyInitialized = false;
    
    /**
     *  Called by instance. All we have to do during the initialisation of this class.
     * 
     */
    public function initialize()
    {

    }
}