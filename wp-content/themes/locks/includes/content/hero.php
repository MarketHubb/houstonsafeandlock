<?php
function get_hero_description_classes()
{
    return 'text-pretty !leading-normal text-base font-normal text-gray-500 md:text-lg lg:text-[1.1rem]';
}

function output_hero_callout(array $hero_attributes)
{
    if (empty($hero_attributes) || empty($hero_attributes['callout'])) return;

    return '<span class="block font-normal tracking-[.2rem] text-gray-400 text-base uppercase mb-2">' . $hero_attributes['callout'] . '</span>';
}

function output_hero_heading(array $hero_attributes)
{
    if (empty($hero_attributes) || empty($hero_attributes['heading'])) return;

    return '<h1 class="text-2xl md:text-4xl lg:text-5xl text-gray-800 font-semibold !leading-none mb-6">' . $hero_attributes['heading'] . '</h1>';
}

function output_hero_description(array $hero_attributes)
{
    if (empty($hero_attributes) || empty($hero_attributes['description'])) return;

    return '<p class="' . get_hero_description_classes() . '">' . $hero_attributes['description'] . '</p>';
}

function output_hero($hero_attributes)
{
    $hero  = '<div class="flex flex-col justify-start gap-y-1 max-w-2xl">';
    $hero .= output_hero_callout($hero_attributes);
    $hero .= output_hero_heading($hero_attributes);
    $hero .= output_hero_description($hero_attributes);
    $hero .= '</div>';

    return $hero;
}