<?php

function create_setting($wp_customize, $name, $label, $section, $control_class = 'WP_Customize_Control')
{
    $wp_customize->add_setting($name);

    $wp_customize->add_control(new $control_class($wp_customize, $name, array(
        'label' => __($label, $name),
        'section' => $section
    )));
}

function res_theme_options($wp_customize)
{
    $wp_customize->add_section('res_general', array(
        'title' => __('Allgemein', 'themeslug'),
        'priority' => 10,
        'description' => 'Allgemeine Daten',
    ));

    create_setting($wp_customize, 'kunde_mail', 'E-Mail', 'res_general');
    create_setting($wp_customize, 'kunde_tel', 'Telefon', 'res_general');
    create_setting($wp_customize, 'kunde_web', 'Webseite', 'res_general');
    create_setting($wp_customize, 'kunde_logo', 'Logo', 'res_general', 'WP_Customize_Image_Control');
}

add_action('customize_register', 'res_theme_options');