<?php
class HelperFrontend
{
    public static function createButton($type, $name, $value, $id, $text, $class)
    {
        return sprintf('<button type="%s" id="%s" name="%s" value="%s" class="btn %s">%s</button>', $type, $id, $name, $value, $class, $text);
    }
}
