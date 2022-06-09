<?php
class Form
{
    public static function input($type, $name, $value, $class)
    {
        $xhtml = sprintf('<input type="%s" class="%s" name="%s" value="%s">', $type, $class, $name, $value);
        return $xhtml;
    }

    public static function label($text, $class)
    {
        $xhtml = sprintf('<label>%s <span class="%s">*</span></label>', $text, $class);
        return $xhtml;
    }

    public static function select($name, $arrOptions, $nameDefaultSelect, $keySelected = '')
    {
        $options = '<option value="default"> - Select '.$nameDefaultSelect.' - </option>';
        foreach ($arrOptions as $key => $value) {
            $selected = ((string)$key === $keySelected) ? 'selected' : '';
            $options .= sprintf('<option %s value="%s">%s</option>', $selected, $key, $value);
        }

        return sprintf('<select class="custom-select" name="%s">%s</select>', $name, $options);
    }

    public static function row ($label, $input) {
        return sprintf('<div class="form-group">%s %s</div>', $label, $input);
    }

    public static function showElements($elements)
    {
        $xhtml = '';
        foreach ($elements as $value) {
            $xhtml .= Form::row($value['label'], $value['element']);
        }
        return $xhtml;
    }
}