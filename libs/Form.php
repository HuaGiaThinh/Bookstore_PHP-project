<?php
class Form
{
    public static function input($type, $name, $value, $class, $attr = '')
    {
        $xhtml = sprintf('<input type="%s" class="%s" name="%s" value="%s" %s>', $type, $class, $name, $value, $attr);
        return $xhtml;
    }

    public static function label($text, $required = true)
    {
        if ($required) $xthmlRequired = '<span class="text-danger">*</span>';
        $xhtml = sprintf('<label>%s %s</label>', $text, ($xthmlRequired ?? ''));
        return $xhtml;
    }

    public static function select($name, $arrOptions, $class, $keySelected = '', $attr = '')
    {
        $options = '';
        foreach ($arrOptions as $key => $value) {
            $selected = ((string)$key === $keySelected) ? 'selected' : '';
            $options .= sprintf('<option %s value="%s">%s</option>', $selected, $key, $value);
        }

        return sprintf('<select class="form-control %s" name="%s" %s>%s</select>', $class, $name, $attr, $options);
    }

    public static function row($label, $input, $classRow)
    {
        return sprintf('<div class="%s">%s %s</div>', $classRow, $label, $input);
    }

    public static function showElements($elements, $classRow = 'form-group')
    {
        $xhtml = '';
        foreach ($elements as $value) {
            $xhtml .= Form::row($value['label'], $value['element'], $classRow);
        }
        return $xhtml;
    }

    public static function createIconLogin($icon)
    {
        return sprintf('
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="%s"></span>
                </div>
            </div>', $icon);
    }
}
