<?php
function classes_text_input()
{
    return ' appearance-none bg-white placeholder:text-gray-700 hover:placeholder:text-gray-800 focus:placeholder:text-transparent !rounded-md w-full !py-2.5 !pl-3 !pr-10 outline outline-1 -outline-offset-1 outline-gray-300 ';
}

function classes_search_input_focus()
{
    return 'focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 text-left disabled:pointer-events-none';
}

function classes_search_input(bool $include_focus_classes = true)
{
    $base_classes = classes_text_input();

    return $include_focus_classes
        ? $base_classes . classes_search_input_focus()
        : $base_classes;
}

