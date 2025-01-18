<?php
function form_section_heading($heading, $description = null)
{
    $form_heading  = '<div class="mb-6">';
    $form_heading .= '<h2 class="text-lg font-semibold text-gray-900">' . $heading . '</h2>';

    if ($description) {
        $form_heading .= '<p class="text-sm text-gray-600">' . $description . '</p>';
    }

    $form_heading .= '</div>';

    return $form_heading;
}

function form_continue_btn($btn_text) 
{
    $form_continue_btn = '<div class="my-8">';
    $form_continue_btn .= '<button type="submit" class="w-full rounded-md border border-transparent bg-brandBlue-500 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-brandBlue-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">' . $btn_text . '</button>';
    $form_continue_btn .= '</div>';

    return $form_continue_btn;
}
