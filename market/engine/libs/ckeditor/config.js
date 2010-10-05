/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    config.language = 'ru';
    config.toolbar_Basic =
    [
    ['Source'],
    ['Cut','Copy','Paste'],
    ['Undo','Redo','-','Find','-','SelectAll','RemoveFormat'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
    ['Maximize'],['-','Subscript','Superscript'],
    '/',
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink'],
    ['Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Image','Table','HorizontalRule','SpecialChar'],
    ['Bold','Italic','Underline','Strike']
    ];
    config.toolbar = 'Basic';
    
    config.width = 580;
    config.resize_minWidth = 580;
    config.resize_maxWidth = 800;
};
