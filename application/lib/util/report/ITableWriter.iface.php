<?php
declare (strict_types = 1);
namespace Report;

/**
 * Define uma interface para escrita de tabelas
 */
interface ITableWriter
{
    public function __construct($widths);
    public function addStyle($stylename, $fontface, $fontsize, $fontstyle, $fontcolor, $fillcolor);
    public function addRow();
    public function addCell($content, $align, $stylename = null, $colspan = 1);
    public function save($filename);
}
