<?php

class Wsbb_Visual_Editor extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Visual Editor', 'wsbb'),
            'description'     => __('Rich text content with WordPress visual editor.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-visual-editor/',
            'url'             => WSBB_MODULES_URL . 'wsbb-visual-editor/',
            'icon'            => 'editor-alignleft.svg',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-visual-editor', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
    }
}

// Register the module
FLBuilder::register_module('Wsbb_Visual_Editor', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('Content', 'wsbb'),
                'fields' => array(
                    'editor_content' => array(
                        'type'          => 'editor',
                        'label'         => __('Content', 'wsbb'),
                        'media_buttons' => true,
                        'wpautop'       => true,
                        'rows'          => '12',
                    ),
                ),
            ),
            'style' => array(
                'title'  => __('Style', 'wsbb'),
                'fields' => array(
                    'background_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-editor-inner',
                            'property' => 'background-color',
                        ),
                    ),
                    'text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-editor-inner',
                            'property' => 'color',
                        ),
                    ),
                    'padding' => array(
                        'type'        => 'dimension',
                        'label'       => __('Padding', 'wsbb'),
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-editor-inner',
                            'property' => 'padding',
                        ),
                    ),
                ),
            ),
        ),
    ),
));
