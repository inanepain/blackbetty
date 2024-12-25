<?php
/**
 * Module Version Update RegEx
 * Filter: *.js
 * Search Inane Only: (import.*inane/.*.js\?v=)(?:[0-9]*)
 * Search All: (import.*.js\?v=)(?:[0-9]*)
 * Replace: $1X
 * Where: X = new version number
 */

/*
$arr = get_defined_functions(true);
sort($arr['internal']);
foreach ($arr['internal'] as $rr) echo "use function {$rr};" . PHP_EOL;
 */
/*
// LIST
use function array_combine;
use function array_map;
use function array_merge;
use function base64_decode;
use function class_exists;
use function compact;
use function count;
use function current;
use function date;
use function explode;
use function file_exists;
use function file;
use function getenv;
use function gettype;
use function header;
use function implode;
use function in_array;
use function intval;
use function is_array;
use function lcfirst;
use function link;
use function max;
use function mb_strlen;
use function putenv;
use function range;
use function round;
use function settype;
use function str_replace;
use function time;
use function trim;
use function ucfirst;
use function ucwords;
/*
/** vscode-fold=4 */

$v = '?v=';
$v .= \Application\Module::isDev() ? time() : \Application\Module::VERSION;
return [
    'view_helper_config' => [
        'asset' => [
            /**
             * URL standards
             * 
             * Inane: no version numbers in url
             * Library: versioned url
             */
            'resource_map' => [
                // Config
                'config'                        => 'js/inane/config.min.js' . $v,
                'config/dev'                    => 'js/inane/config.js' . $v,
                // Site
				'main/js'                       => 'js/main.min.js' . $v,
				'main/js/dev'                   => 'js/main.js' . $v,
                'main/css'                      => 'css/style.css' . $v,
                // Inane
                // Inane: Extend
                'inane/extend/array'            => 'js/inane/extend/array.min.js' . $v,
                'inane/extend/array/dev'        => 'js/inane/extend/array.js' . $v,
                'inane/extend/date'             => 'js/inane/extend/date.min.js' . $v,
                'inane/extend/date/dev'         => 'js/inane/extend/date.js' . $v,
                'inane/extend/number'           => 'js/inane/extend/number.min.js' . $v,
                'inane/extend/number/dev'       => 'js/inane/extend/number.js' . $v,
                'inane/extend/object'           => 'js/inane/extend/object.min.js' . $v,
                'inane/extend/object/dev'       => 'js/inane/extend/object.js' . $v,
                'inane/extend/string'           => 'js/inane/extend/string.min.js' . $v,
                'inane/extend/string/dev'       => 'js/inane/extend/string.js' . $v,
                // Inane: Inane
                'inane/inane'                   => 'js/inane/inane.min.js' . $v,
                'inane/inane/dev'               => 'js/inane/inane.js' . $v,
                // Inane: JSLoader
                'inane/jsloader'                => 'js/inane/jsloader/jsloader.min.js' . $v,
                'inane/jsloader/dev'            => 'js/inane/jsloader/jsloader.js' . $v,
                'inane/jsloader/modules'        => 'js/jsloader-modules.min.js' . $v,
                'inane/jsloader/modules/dev'    => 'js/jsloader-modules.js' . $v,
                'inane/jsloader/spinner'        => 'js/inane/jsloader/jsloader-spinner-0.6.0.css' . $v,
                // Inane: Controls
                'inane/control/image-drop'      => 'js/inane/control/image-drop/image-drop.min.js' . $v,
                'inane/control/textset'         => 'js/inane/control/textset/inane-textset.min.js' . $v,
                'inane/control/gravatar'        => 'js/inane/control/gravatar/inane-gravatar.min.js' . $v,
                'inane/control/popupinfo'       => 'js/inane/control/popupinfo/popupinfo.min.js' . $v,
                'inane/control/quickheader'     => 'js/inane/control/quickheader/quickheader.min.js' . $v,
                'inane/control/quickheader/dev' => 'js/inane/control/quickheader/quickheader.js' . $v,
                'inane/control/toggleswitch'    => 'js/inane/control/toggleswitch/toggleswitch.min.js' . $v,
                'inane/control/toggleswitch/dev'=> 'js/inane/control/toggleswitch/toggleswitch.js' . $v,
                // Inane: Helpers
                'inane/dumper'                  => 'js/inane/dumperjs.min.js' . $v,
                'inane/dumper/dev'              => 'js/inane/dumperjs.js' . $v,
                'inane/dumper/module'           => 'js/inane/dumper.min.js',
                'inane/dumper/module/dev'       => 'js/inane/dumper.js',
                
                // Inane: IMRoot
                'inane/manicss'                 => 'js/inane/pg/anicss.min.js' . $v,
                'inane/manicss/dev'             => 'js/inane/pg/anicss.js' . $v,
                'inane/micbase'                 => 'js/inane/pg/icBase.min.js' . $v,
                'inane/micbase/dev'             => 'js/inane/pg/icBase.js' . $v,
                'inane/miobject'                => 'js/inane/pg/iobject.min.js' . $v,
                'inane/miobject/dev'            => 'js/inane/pg/iobject.js' . $v,
                // Inane: ICRoot
                'inane/ihelper'                 => 'js/inane/icroot/iHelper.min.js' . $v,
                'inane/ihelper/dev'             => 'js/inane/icroot/iHelper.js' . $v,
                'inane/ifile'                   => 'js/inane/icroot/iFile.min.js' . $v,
                'inane/ioptions'                => 'js/inane/icroot/iOptions.min.js' . $v,
                'inane/ioptions/dev'            => 'js/inane/icroot/iOptions.js' . $v,
                'inane/ishortcut'               => 'js/inane/icroot/iShortcut.min.js' . $v,
                'inane/ishortcut/dev'           => 'js/inane/icroot/iShortcut.js' . $v,
                'inane/istr'                    => 'js/inane/icroot/iStr.min.js' . $v,
                'inane/itemplate'               => 'js/inane/icroot/iTemplate.min.js' . $v,
                'inane/itemplate/dev'           => 'js/inane/icroot/iTemplate.js' . $v,
                'inane/iview'                   => 'js/inane/icroot/iView.min.js' . $v,
                'inane/iview/dev'               => 'js/inane/icroot/iView.js' . $v,
                // Inane: Font
                'inane/peepfont'                => 'js/inane/peepfont/peepfont.css' . $v,
                // Inane: Depricated
                'inane/db/sync'                 => 'js/inane/db/dbsync.min.js' . $v,
                'inane/db/layer'                => 'js/inane/db/dblayer.min.js' . $v,

                // LIBRARIES
                // MATERIAL-ICONS
                'css/material-icons'            => 'lib/material-icons/m-i/material-icons.css' . $v,

                // JS
                'lib/jquery'                    => 'lib/jquery/3.5.1/jquery.min.js',
                'lib/jquery/slim'               => 'lib/jquery/3.5.1/jquery.slim.min.js',
                'lib/jquery/easing'             => 'lib/jquery/easing/1.4.1/jquery.easing.min.js',
                'lib/jquery/migrate'            => 'lib/jquery/migrate/3.3.2/jquery.migrate.min.js',
                
                'lib/underscore'                => 'lib/underscore/1.12.0/underscore.min.js',
                'lib/underscore/1.11.0'         => 'lib/underscore/1.11.0/underscore.min.js',
                'lib/underscore/1.10.2'         => 'lib/underscore/1.10.2/underscore.min.js',
                'lib/backbone'                  => 'lib/backbone/1.4.0/backbone.min.js',
                'lib/backbone/radio'            => 'lib/backbone/radio/2.0.0/backbone.radio.min.js',
                'lib/backbone/undo'             => 'lib/backbone/undo/0.2.6/backbone.undo.min.js',
                'lib/backbone/marionette'       => 'lib/backbone/marionette/4.1.2/backbone.marionette.min.js',

                'lib/bootstrap'                 => 'lib/bootstrap/4.3.2/js/bootstrap.bundle.min.js',
                'css/bootstrap'                 => 'lib/bootstrap/4.3.2/css/bootstrap.min.css',
                'lib/bootstrap/notify'          => 'lib/bootstrap-notify/bootstrap-notify-3.1.5.min.js',

                'lib/logger'                    => 'lib/logger/1.6.1/logger.min.js',
                'lib/bootbox'                   => 'lib/bootbox/5.4.0/bootbox.all.min.js',
                'lib/inputmask'                 => 'lib/inputmask/5.0.4/inputmask.min.js',
                'lib/inputmask/binding'         => 'lib/inputmask/5.0.4/bindings/inputmask.binding.js',
                'lib/moment'                    => 'lib/moment/2.26.0/moment.min.js',
                // TAGIFY
                'lib/tagify'                    => 'lib/tagify/3.21.4/tagify.min.js',
                'css/tagify'                    => 'lib/tagify/3.21.4/tagify.css',
                'lib/tagify/3.17.7'             => 'lib/tagify/3.17.7/tagify.min.js',
                'css/tagify/3.17.7'             => 'lib/tagify/3.17.7/tagify.css',
                'lib/tagify/3.7.2'              => 'lib/tagify/3.7.2/tagify.min.js',
                'css/tagify/3.7.2'              => 'lib/tagify/3.7.2/tagify.css',
                // POPPER
                'lib/popper'                    => 'lib/popper/2.4.1/popper.min.js',
                // SIGNATUREPAD
                'lib/signaturepad'              => 'lib/signaturepad/3.0.0-b3/signaturepad.min.js',

                'lib/commonmark'                => 'lib/commonmark/0.29.3/commonmark.js',

                // Datatables
                'css/datatables'                => 'lib/datatables/1.10.21/datatables.min.css',
                'lib/datatables'                => 'lib/datatables/1.10.21/datatables.min.js',

                // Tinysort
                'lib/tinysort'                  => 'lib/tinysort/2.3.6/tinysort.min.js',

                // DragSort
                'css/dragsort'                  => 'lib/dragsort/1.0.8/dragsort.css',
                'lib/dragsort'                  => 'lib/dragsort/1.0.8/dragsort.js',

                // Mermaid
                'lib/mermaid'                   => 'lib/mermaid/5.15.0/mermaid.min.js',

                // CSS
                'css/pretty-checkbox'           => 'lib/pretty-checkbox/3.0/pretty-checkbox.min.css',
                // ANIMATECSS
                'css/animatecss'                => 'lib/animatecss/4.1.0/animate.min.css',
                'css/animatecss/3.7.2'          => 'lib/animatecss/3.7.2/animate.min.css',

                // JSONEditor
                'lib/jsoneditor'                => 'lib/jsoneditor/9.2.0/jsoneditor.min.js',
                'css/jsoneditor'                => 'lib/jsoneditor/9.2.0/jsoneditor.css',

                // AVJ
                'lib/ajv'                       => 'lib/ajv/7.1.1/ajv7.min.js',
                'lib/ajv/2019'                  => 'lib/ajv/7.1.1/ajv2019.bundle.js',

                // JMESPath
                'lib/jmespath'                       => 'lib/jmespath/0.15.0/jmespath.js',
            ],
        ],
    ],
];
