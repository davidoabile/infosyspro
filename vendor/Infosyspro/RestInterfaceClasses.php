<?php
namespace Infosyspro;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface RestInterfaceClasses
{
    /**
     * These are rest RESTful APIs function
     * They are required by all classes that should exposes their methods as APIs
     */
    public  function get( $id , Array $data);
    public  function getList( Array $data );
    public  function update(  $id, Array $data );
    public  function create (Array $data );
    public  function delete( $id );
}
