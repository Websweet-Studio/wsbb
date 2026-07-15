(function ($) {
    'use strict';

    var $w = window.parent.jQuery || $; // parent jQuery has .data('editor')

    var shortcodes = [
        { label: 'Featured Image',          code: '[wsbb post:featured_image size="large" display="tag" linked="yes"]' },
        { label: 'Post Title',              code: '[wsbb post:title]' },
        { label: 'Post Link (Title)',       code: '[wsbb post:link text="title"]' },
        { label: 'Post Link (Custom Text)', code: '[wsbb post:link text="custom" custom_text="Read More \u00bb"]' },
        { label: 'Author Name',             code: '[wsbb post:author_name link="yes"]' },
        { label: 'Post Date',               code: '[wsbb post:date format="F j, Y"]' },
        { label: 'Post Excerpt',            code: '[wsbb post:excerpt length="55" more="..."]' },
        { label: 'Conditional Image Block', code: '[wsbb-if post:featured_image]\n[wsbb post:featured_image size="large" display="tag" linked="yes"]\n[/wsbb-if]' },
        { label: 'Terms (Category)',        code: '[wsbb post:terms_list taxonomy="category" separator=", " linked="yes"]' },
        { label: 'Terms (Tags)',            code: '[wsbb post:terms_list taxonomy="post_tag" separator=", " linked="yes"]' }
    ];

    function injectStyles(doc) {
        if (doc.getElementById('wsbb-sc-picker-styles')) return;
        var css = [
            '.wsbb-shortcode-toolbar{display:flex;align-items:center;gap:6px;padding:6px 0;position:relative}',
            '.wsbb-shortcode-btn{background:#f0f0f1;border:1px solid #c3c4c7;border-radius:3px;padding:4px 12px;font-size:12px;font-weight:600;cursor:pointer;color:#1d2327;line-height:1.6;transition:background .15s,border-color .15s}',
            '.wsbb-shortcode-btn:hover{background:#dcdcde;border-color:#8c8f94}',
            '.wsbb-shortcode-dropdown{display:none;position:absolute;top:100%;left:0;z-index:999999;min-width:420px;max-height:320px;overflow-y:auto;background:#fff;border:1px solid #dcdcde;border-radius:4px;box-shadow:0 4px 20px rgba(0,0,0,.12)}',
            '.wsbb-shortcode-dropdown.wsbb-open{display:block}',
            '.wsbb-shortcode-item{padding:8px 12px;cursor:pointer;border-bottom:1px solid #f0f0f1;transition:background .12s}',
            '.wsbb-shortcode-item:last-child{border-bottom:none}',
            '.wsbb-shortcode-item:hover{background:#f6f7f7}',
            '.wsbb-shortcode-label{display:block;font-size:12px;font-weight:600;color:#1d2327;margin-bottom:2px}',
            '.wsbb-shortcode-preview{display:block;font-size:11px;color:#50575e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;direction:rtl;text-align:left;background:#f0f0f1;padding:2px 6px;border-radius:2px}'
        ].join('');
        var s = doc.createElement('style');
        s.id = 'wsbb-sc-picker-styles';
        s.textContent = css;
        doc.head.appendChild(s);
    }

    function buildToolbar(pdoc, $field, $codeField) {
        var $toolbar = $w(
            '<div class="wsbb-shortcode-toolbar">' +
            '  <button type="button" class="wsbb-shortcode-btn">+ Insert Shortcode</button>' +
            '</div>'
        );
        $codeField.before($toolbar);

        var $dropdown = $w('<div class="wsbb-shortcode-dropdown"></div>');
        $.each(shortcodes, function (i, sc) {
            var esc = sc.code.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            $dropdown.append(
                '<div class="wsbb-shortcode-item" data-code="' + esc + '">' +
                '<span class="wsbb-shortcode-label">' + sc.label + '</span>' +
                '<code class="wsbb-shortcode-preview">' + esc.replace(/\n/g, '<br>') + '</code>' +
                '</div>'
            );
        });
        $toolbar.append($dropdown);

        // Toggle
        $toolbar.find('.wsbb-shortcode-btn').on('click', function (e) {
            e.stopPropagation();
            $dropdown.toggleClass('wsbb-open');
        });

        // Insert at cursor
        $dropdown.on('click', '.wsbb-shortcode-item', function () {
            var code = $w(this).data('code');
            var editor = $field.data('editor');
            if (editor) {
                var pos = editor.getCursorPosition();
                editor.session.insert(pos, code);
                editor.focus();
            }
            $dropdown.removeClass('wsbb-open');
        });

        // Close on outside click
        $w(pdoc).on('click', function (e) {
            if (!$toolbar.find(e.target).length) {
                $dropdown.removeClass('wsbb-open');
            }
        });
    }

    FLBuilder.registerModuleHelper('wsbb-post', {

        init: function () {
            var form = this.getForm();   // parent.document form (raw DOM)
            var pdoc = form.ownerDocument;

            injectStyles(pdoc);

            var $field = $w(form).find('[data-name="custom_layout"]');
            if (!$field.length || $field.find('.wsbb-shortcode-toolbar').length) return;

            var $codeField = $field.find('.fl-code-field');
            if (!$codeField.length) return;

            buildToolbar(pdoc, $field, $codeField);
        }

    });

})(jQuery);
