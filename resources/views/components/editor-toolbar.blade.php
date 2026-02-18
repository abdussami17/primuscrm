{{-- Reusable Email Editor Toolbar Component --}}
<style>
/* Component-local toolbar/editor styles */
.outlook-editor-component { --toolbar-bg: #fff; }
.outlook-toolbar { display:flex; flex-wrap:wrap; gap:8px; align-items:center; padding:10px; background:var(--toolbar-bg); border-bottom:1px solid #e9ecef; }
.toolbar-select { padding:6px 8px; border:1px solid #dcdcdc; border-radius:4px; background:#fff; }
.toolbar-btn { background:transparent; border:0; padding:6px 8px; cursor:pointer; border-radius:4px; }
.toolbar-btn i { font-size:16px; }
.toolbar-separator { width:1px; height:28px; background:#e9ecef; margin:0 6px; }
.color-picker-wrapper { position:relative; }
.color-dropdown, .highlight-color-dropdown, .text-color-dropdown { position:absolute; top:36px; left:0; background:#fff; border:1px solid #ddd; padding:6px; display:flex; gap:6px; flex-wrap:wrap; z-index:2000; box-shadow:0 6px 20px rgba(16,24,40,0.08); display:none; }
.color-dropdown.open { display:flex; }
.color-swatch { width:22px; height:18px; border-radius:3px; border:1px solid rgba(0,0,0,0.12); cursor:pointer; }
.color-underline { width:28px; height:4px; border-radius:2px; margin-left:6px; display:inline-block; vertical-align:middle; }
.color-picker-btn { display:inline-flex; align-items:center; gap:6px; padding:6px 8px; border:1px solid transparent; background:#fff; border-radius:6px; cursor:pointer; }
.color-picker-btn:hover { border-color:#e2e8f0; }
.text-color-indicator, .highlight-color-indicator { width:22px; height:12px; border-radius:3px; border:1px solid rgba(0,0,0,0.08); }
.text-color-dropdown, .highlight-color-dropdown { min-width:140px; padding:8px; }
.color-dropdown button.color-swatch { width:20px; height:20px; }
.editor-wrapper { padding:12px; }
.editor { min-height:220px; border:1px solid #e6edf3; padding:12px; border-radius:6px; background:#fff; }
.html-textarea { width:100%; box-sizing:border-box; }
.table-grid-popup { position:absolute; background:#fff; border:1px solid #ddd; padding:8px; display:none; z-index:2000; }
.table-grid-popup.table-grid-popup-hidden { display:none; }
.voice-btn { border:0; background:transparent; padding:6px; cursor:pointer; }
</style>
<div class="card p-0 mb-4 outlook-editor-component" {{ $attributes }}>
    <div class="outlook-toolbar">
        {{-- Font Family --}}
        <select class="toolbar-select toolbar-font-family" title="Font family">
            <option value="Arial">Arial</option>
            <option value="Times New Roman">Times New Roman</option>
            <option value="Helvetica">Helvetica</option>
            <option value="Georgia">Georgia</option>
            <option value="Verdana">Verdana</option>
            <option value="Courier New">Courier New</option>
        </select>

        {{-- Font Size --}}
        <select class="toolbar-select toolbar-font-size" title="Font size">
            <option value="8px">8</option>
            <option value="10px">10</option>
            <option value="12px">12</option>
            <option value="14px" selected>14</option>
            <option value="16px">16</option>
            <option value="18px">18</option>
            <option value="24px">24</option>
            <option value="32px">32</option>
        </select>

        <div class="toolbar-separator"></div>

        {{-- Basic Formatting --}}
        <button type="button" class="toolbar-btn" data-cmd="bold" title="Bold (Ctrl+B)">
            <i class="bi bi-type-bold"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="italic" title="Italic (Ctrl+I)">
            <i class="bi bi-type-italic"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="underline" title="Underline (Ctrl+U)">
            <i class="bi bi-type-underline"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="strikeThrough" title="Strikethrough">
            <i class="bi bi-type-strikethrough"></i>
        </button>

        <div class="toolbar-separator"></div>

        {{-- Text Color --}}
        <div class="color-picker-wrapper">
            <button type="button" class="color-picker-btn text-color-btn" title="Text color">
                <i class="bi bi-fonts" style="font-size: 18px;"></i>
                <div class="color-underline text-color-indicator" style="background: #000000;"></div>
            </button>
            <div class="color-dropdown text-color-dropdown"></div>
        </div>

        {{-- Highlight Color --}}
        <div class="color-picker-wrapper">
            <button type="button" class="color-picker-btn highlight-color-btn" title="Highlight color">
                <i class="bi bi-highlighter"></i>
                <div class="color-underline highlight-color-indicator" style="background: #ffff00;"></div>
            </button>
            <div class="color-dropdown highlight-color-dropdown"></div>
        </div>

        <div class="toolbar-separator"></div>

        {{-- Alignment --}}
        <button type="button" class="toolbar-btn" data-cmd="justifyLeft" title="Align left">
            <i class="bi bi-text-left"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="justifyCenter" title="Align center">
            <i class="bi bi-text-center"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="justifyRight" title="Align right">
            <i class="bi bi-text-right"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="justifyFull" title="Justify">
            <i class="bi bi-justify"></i>
        </button>

        <div class="toolbar-separator"></div>

        {{-- Lists and Indentation --}}
        <button type="button" class="toolbar-btn" data-cmd="insertUnorderedList" title="Bullet list">
            <i class="bi bi-list-ul"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="insertOrderedList" title="Numbered list">
            <i class="bi bi-list-ol"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="indent" title="Increase indent">
            <i class="bi bi-indent"></i>
        </button>
        <button type="button" class="toolbar-btn" data-cmd="outdent" title="Decrease indent">
            <i class="bi bi-unindent"></i>
        </button>

        <div class="toolbar-separator"></div>

        {{-- Insert Options --}}
        <div class="color-picker-wrapper">
            <button type="button" class="toolbar-btn btn-table" title="Insert table">
                <i class="bi bi-table"></i>
            </button>
            <div class="table-grid-popup table-grid-popup-hidden">
                <div class="table-grid"></div>
                <div class="table-size-label">1 x 1 Table</div>
            </div>
        </div>

        <button type="button" class="toolbar-btn btn-image" title="Insert image">
            <i class="bi bi-image"></i>
        </button>

        <button type="button" class="toolbar-btn btn-link" title="Insert link">
            <i class="bi bi-link-45deg"></i>
        </button>

        <button type="button" class="toolbar-btn btn-attach" title="Attach file">
            <i class="bi bi-paperclip"></i>
        </button>

        <button type="button" class="toolbar-btn btn-clear-format" title="Clear formatting">
            <i class="bi bi-eraser"></i>
        </button>

        <div class="toolbar-separator"></div>

        {{-- Smart Text --}}
        <button type="button" class="toolbar-btn btn-smart-text" title="Smart Text - Enhance with AI">
            <i class="bi bi-magic"></i>
        </button>

        <div class="toolbar-separator"></div>

        {{-- HTML Edit Mode --}}
        <button type="button" class="toolbar-btn btn-html-mode" title="Edit HTML / Switch to HTML mode">
            <i class="bi bi-code-slash"></i>
        </button>

        {{-- Voice Input --}}
        <button type="button" class="voice-btn btn-voice" title="Voice to text">
            <i class="bi bi-mic-fill"></i>
        </button>
    </div>

    {{-- HTML Textarea (Hidden by default) --}}

</div>


<script>

(function () {
  document.addEventListener('DOMContentLoaded', init);

  function init() {
    console.info('[OUTLOOK-EDITOR] init');
    const COLORS = [
      '#000000', '#444444', '#666666', '#999999', '#CCCCCC', '#FFFFFF',
      '#ff0000', '#ff7f00', '#ffff00', '#7fff00', '#00ff00', '#00ffff',
      '#007fff', '#0000ff', '#7f00ff', '#ff00ff', '#ff007f', '#8B4513'
    ];

    const editor = document.getElementById('editor');
    if (!editor) {
      console.error('[OUTLOOK-EDITOR] No element with id="editor" found.');
      return;
    }

    // Try to prefer CSS-based styling where supported
    try { document.execCommand('styleWithCSS', false, true); } catch (e) {}

    // -------------------------
    // Utilities
    // -------------------------
    function getSelection() { return window.getSelection ? window.getSelection() : null; }

    function getSelectionHtml() {
      const sel = getSelection();
      if (!sel || sel.rangeCount === 0) return '';
      const container = document.createElement('div');
      for (let i = 0; i < sel.rangeCount; i++) {
        container.appendChild(sel.getRangeAt(i).cloneContents());
      }
      return container.innerHTML;
    }

    function replaceSelectionWithHtml(html) {
      const sel = getSelection();
      if (!sel || sel.rangeCount === 0) {
        // Insert at caret/end if nothing selected
        editor.focus();
        editor.insertAdjacentHTML('beforeend', html);
        return;
      }
      const range = sel.getRangeAt(0);
      range.deleteContents();
      const frag = range.createContextualFragment(html);
      range.insertNode(frag);
      // place caret after inserted content
      range.collapse(false);
      sel.removeAllRanges();
      sel.addRange(range);
    }

    function applyInlineStyle(styleObj) {
      const sel = getSelection();
      if (!sel || sel.rangeCount === 0) {
        // No selection: insert an empty styled span and place caret inside
        const span = document.createElement('span');
        Object.keys(styleObj).forEach(k => span.style.setProperty(k, styleObj[k]));
        span.innerHTML = '\u200B';
        editor.appendChild(span);
        const range = document.createRange();
        range.setStart(span.firstChild, 0);
        range.setEnd(span.firstChild, 0);
        sel && sel.removeAllRanges();
        sel && sel.addRange(range);
        editor.focus();
        return;
      }
      const range = sel.getRangeAt(0);
      if (range.collapsed) {
        // collapsed caret: insert styled span
        const span = document.createElement('span');
        Object.keys(styleObj).forEach(k => span.style.setProperty(k, styleObj[k]));
        span.innerHTML = '\u200B';
        range.insertNode(span);
        const newRange = document.createRange();
        newRange.setStart(span.firstChild, 0);
        newRange.setEnd(span.firstChild, 0);
        sel.removeAllRanges();
        sel.addRange(newRange);
        editor.focus();
        return;
      }
      // wrap selection
      const html = getSelectionHtml();
      const styleStr = Object.entries(styleObj).map(([k, v]) => `${k}:${v}`).join(';');
      replaceSelectionWithHtml(`<span style="${styleStr}">${html}</span>`);
    }

    function doCommand(cmd, value = null) {
      editor.focus();
      try {
        if (value !== null) document.execCommand(cmd, false, value);
        else document.execCommand(cmd, false, null);
      } catch (err) {
        console.warn('[OUTLOOK-EDITOR] execCommand failed for', cmd, err);
      }
      // notify change
      editor.dispatchEvent(new Event('input', { bubbles: true }));
    }

    // Normalize <font face=""> inserted by some browsers to <span style="font-family:...">
    function normalizeFontTags(root) {
      const container = root || editor;
      const fonts = container.querySelectorAll('font[face]');
      fonts.forEach(f => {
        const face = f.getAttribute('face') || '';
        const span = document.createElement('span');
        if (face) span.style.fontFamily = face;
        span.innerHTML = f.innerHTML;
        f.parentNode && f.parentNode.replaceChild(span, f);
      });
    }

    // -------------------------
    // Color pickers
    // -------------------------
    function populateColorDropdown(dropdown, type) {
      if (!dropdown) return;
      dropdown.innerHTML = '';
      COLORS.forEach(color => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'color-swatch';
        btn.title = color;
        btn.dataset.color = color;
        btn.style.background = color;
        btn.addEventListener('click', (ev) => {
          ev.stopPropagation();
          const col = btn.dataset.color;
          if (type === 'text') {
            // try foreColor, fallback to inline style
            try {
              document.execCommand('foreColor', false, col);
              normalizeFontTags(editor);
            } catch (err) {
              applyInlineStyle({ color: col });
            }
            const ind = dropdown.parentElement.querySelector('.text-color-indicator');
            if (ind) ind.style.background = col;
          } else {
            // highlight
            const ok = document.execCommand('hiliteColor', false, col);
            if (!ok) document.execCommand('backColor', false, col);
            const ind = dropdown.parentElement.querySelector('.highlight-color-indicator');
            if (ind) ind.style.background = col;
          }
          dropdown.classList.remove('open');
          editor.focus();
        });
        dropdown.appendChild(btn);
      });
    }

    document.querySelectorAll('.color-picker-wrapper').forEach(wrapper => {
      const textDd = wrapper.querySelector('.text-color-dropdown');
      const hlDd = wrapper.querySelector('.highlight-color-dropdown');
      if (textDd) populateColorDropdown(textDd, 'text');
      if (hlDd) populateColorDropdown(hlDd, 'highlight');
    });

    // Toggle color dropdowns
    document.querySelectorAll('.color-picker-btn').forEach(btn => {
      btn.addEventListener('click', (ev) => {
        ev.stopPropagation();
        const dd = btn.parentElement.querySelector('.color-dropdown');
        if (!dd) return;
        document.querySelectorAll('.color-dropdown').forEach(x => { if (x !== dd) x.classList.remove('open'); });
        dd.classList.toggle('open');
      });
    });
    // close on outside click
    document.addEventListener('click', (ev) => {
      if (!ev.target.closest('.color-picker-wrapper')) {
        document.querySelectorAll('.color-dropdown').forEach(dd => dd.classList.remove('open'));
      }
    });

    // -------------------------
    // Basic buttons (bold/italic/underline/strike)
    // -------------------------
    document.querySelectorAll('.toolbar-btn[data-cmd]').forEach(btn => {
      const cmd = btn.dataset.cmd;
      // skip those handled specially
      const special = ['insertUnorderedList', 'insertOrderedList', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'];
      if (special.includes(cmd)) return;
      btn.addEventListener('click', (ev) => {
        ev.preventDefault();
        doCommand(cmd);
      });
    });

    // keyboard shortcuts
    editor.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && !e.shiftKey) {
        const key = e.key.toLowerCase();
        if (key === 'b') { e.preventDefault(); doCommand('bold'); }
        if (key === 'i') { e.preventDefault(); doCommand('italic'); }
        if (key === 'u') { e.preventDefault(); doCommand('underline'); }
      }
    });

    // -------------------------
    // Lists: cycle none -> ul -> ol (single repeating behavior)
    // -------------------------
    const ulBtn = document.querySelector('.toolbar-btn[data-cmd="insertUnorderedList"]');
    const olBtn = document.querySelector('.toolbar-btn[data-cmd="insertOrderedList"]');
    let listIndex = 0;
    const listStates = ['none', 'ul', 'ol'];

    function applyList(state) {
      if (state === 'none') {
        // attempt to unwrap list
        try {
          document.execCommand('formatBlock', false, '<p>');
        } catch (err) {
          // fallback toggle
          document.execCommand('insertUnorderedList', false, null);
          document.execCommand('insertUnorderedList', false, null);
        }
      } else if (state === 'ul') document.execCommand('insertUnorderedList', false, null);
      else if (state === 'ol') document.execCommand('insertOrderedList', false, null);
      editor.focus();
    }

    function onListClick(e) {
      e.preventDefault();
      listIndex = (listIndex + 1) % listStates.length;
      applyList(listStates[listIndex]);
      [ulBtn, olBtn].forEach(b => b && b.classList.add('active'));
      setTimeout(() => [ulBtn, olBtn].forEach(b => b && b.classList.remove('active')), 140);
    }
    if (ulBtn) ulBtn.addEventListener('click', onListClick);
    if (olBtn) olBtn.addEventListener('click', onListClick);

    // -------------------------
    // Alignment cycling: left -> center -> right -> justify
    // -------------------------
    const alignLeftBtn = document.querySelector('.toolbar-btn[data-cmd="justifyLeft"]');
    const alignmentBtns = document.querySelectorAll('.toolbar-btn[data-cmd="justifyCenter"], .toolbar-btn[data-cmd="justifyRight"], .toolbar-btn[data-cmd="justifyFull"]');
    const alignmentStates = ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'];
    let alignmentIndex = 0;
    if (alignLeftBtn) {
      alignLeftBtn.addEventListener('click', (e) => {
        e.preventDefault();
        alignmentIndex = (alignmentIndex + 1) % alignmentStates.length;
        doCommand(alignmentStates[alignmentIndex]);
      });
    }
    alignmentBtns.forEach(b => b.addEventListener('click', (e) => { e.preventDefault(); doCommand(b.dataset.cmd); }));

    // indent/outdent
    document.querySelectorAll('.toolbar-btn[data-cmd="indent"], .toolbar-btn[data-cmd="outdent"]').forEach(b => {
      b.addEventListener('click', (e) => { e.preventDefault(); doCommand(b.dataset.cmd); });
    });

    // -------------------------
    // Font family and size
    // -------------------------
    const fontSelect = document.querySelector('.toolbar-font-family');
    const sizeSelect = document.querySelector('.toolbar-font-size');

    function normalizeFontsNow() { setTimeout(() => normalizeFontTags(editor), 0); }

    function applyFontFamily(value) {
      const sel = getSelection();
      const collapsed = !sel || sel.rangeCount === 0 || sel.getRangeAt(0).collapsed;
      if (collapsed) {
        // place styled span so next typing uses font
        applyInlineStyle({ 'font-family': value });
        return;
      }
      try {
        document.execCommand('fontName', false, value);
      } catch (err) {
        applyInlineStyle({ 'font-family': value });
      }
      normalizeFontsNow();
    }

    if (fontSelect) {
      fontSelect.addEventListener('change', (e) => {
        const val = e.target.value;
        if (val) applyFontFamily(val);
      });
    }

    if (sizeSelect) {
      sizeSelect.addEventListener('change', (e) => {
        const val = e.target.value;
        if (val) applyInlineStyle({ 'font-size': val });
      });
    }

    // -------------------------
    // Table insertion popup
    // -------------------------
    const btnTable = document.querySelector('.btn-table');
    const tablePopup = document.querySelector('.table-grid-popup');
    if (btnTable && tablePopup) {
      const grid = tablePopup.querySelector('.table-grid') || tablePopup;
      const sizeLabel = tablePopup.querySelector('.table-size-label');
      const MAX = 8;
      grid.innerHTML = '';
      for (let r = 1; r <= MAX; r++) {
        const row = document.createElement('div');
        row.style.display = 'flex';
        row.style.gap = '4px';
        for (let c = 1; c <= MAX; c++) {
          const cell = document.createElement('div');
          cell.className = 'table-grid-cell';
          cell.dataset.r = r;
          cell.dataset.c = c;
          Object.assign(cell.style, { width: '18px', height: '18px', background: '#f8fafc', border: '1px solid #e6edf3', cursor: 'pointer' });
          cell.addEventListener('mouseenter', () => {
            grid.querySelectorAll('.table-grid-cell').forEach(n => {
              const rr = parseInt(n.dataset.r, 10), cc = parseInt(n.dataset.c, 10);
              n.style.background = (rr <= r && cc <= c) ? '#cfe8ff' : '#f8fafc';
            });
            if (sizeLabel) sizeLabel.textContent = `${r} x ${c} Table`;
          });
          cell.addEventListener('click', (ev) => {
            ev.preventDefault();
            const rows = parseInt(cell.dataset.r, 10), cols = parseInt(cell.dataset.c, 10);
            let html = '<table style="border-collapse:collapse; width:100%;">';
            for (let rr = 0; rr < rows; rr++) {
              html += '<tr>';
              for (let cc = 0; cc < cols; cc++) html += '<td style="border:1px solid #e6edf3; padding:8px;">&nbsp;</td>';
              html += '</tr>';
            }
            html += '</table><p></p>';
            replaceSelectionWithHtml(html);
            tablePopup.classList.add('table-grid-popup-hidden');
            editor.focus();
          });
          row.appendChild(cell);
        }
        grid.appendChild(row);
      }

      btnTable.addEventListener('click', (ev) => {
        ev.stopPropagation();
        tablePopup.classList.toggle('table-grid-popup-hidden');
        // approximate positioning
        tablePopup.style.top = (btnTable.offsetTop + btnTable.offsetHeight + 6) + 'px';
        tablePopup.style.left = (btnTable.offsetLeft) + 'px';
      });

      document.addEventListener('click', (ev) => {
        if (!ev.target.closest('.btn-table') && !ev.target.closest('.table-grid-popup')) {
          tablePopup.classList.add('table-grid-popup-hidden');
        }
      });
    }

    // -------------------------
    // Image insertion
    // -------------------------
    const btnImage = document.querySelector('.btn-image');
    if (btnImage) {
      const fileInput = document.createElement('input');
      fileInput.type = 'file';
      fileInput.accept = 'image/*';
      fileInput.style.display = 'none';
      document.body.appendChild(fileInput);

      btnImage.addEventListener('click', () => fileInput.click());

      fileInput.addEventListener('change', (e) => {
        const f = e.target.files && e.target.files[0];
        if (!f) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
          const src = ev.target.result;
          replaceSelectionWithHtml(`<img src="${src}" style="max-width:100%;" alt="${f.name || ''}" />`);
          editor.focus();
        };
        reader.readAsDataURL(f);
      });
    }

    // -------------------------
    // Link insertion
    // -------------------------
    const btnLink = document.querySelector('.btn-link');
    if (btnLink) {
      btnLink.addEventListener('click', (ev) => {
        ev.preventDefault();
        const selHtml = getSelectionHtml() || '';
        let url = window.prompt('Enter URL', 'https://');
        if (!url) return;
        if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
        if (!selHtml.trim()) replaceSelectionWithHtml(`<a href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>`);
        else document.execCommand('createLink', false, url);
        editor.focus();
      });
    }

    // -------------------------
    // Attachment placeholder
    // -------------------------
    const btnAttach = document.querySelector('.btn-attach');
    if (btnAttach) {
      const fileAttach = document.createElement('input');
      fileAttach.type = 'file';
      fileAttach.style.display = 'none';
      document.body.appendChild(fileAttach);

      btnAttach.addEventListener('click', () => fileAttach.click());

      fileAttach.addEventListener('change', (e) => {
        const f = e.target.files && e.target.files[0];
        if (!f) return;
        const ph = `<a href="#" class="attachment" data-filename="${f.name}">${f.name}</a>`;
        replaceSelectionWithHtml(ph);
        editor.focus();
      });
    }

    // -------------------------
    // Clear formatting
    // -------------------------
    const btnClear = document.querySelector('.btn-clear-format');
    if (btnClear) {
      btnClear.addEventListener('click', (ev) => {
        ev.preventDefault();
        document.execCommand('removeFormat', false, null);
        const sel = getSelection();
        if (sel && sel.rangeCount > 0) {
          const range = sel.getRangeAt(0);
          const text = range.toString();
          replaceSelectionWithHtml(text.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
        }
        editor.focus();
      });
    }

    // -------------------------
    // Smart text placeholder
    // -------------------------
    const btnSmart = document.querySelector('.btn-smart-text');
    if (btnSmart) {
      btnSmart.addEventListener('click', (ev) => {
        ev.preventDefault();
        replaceSelectionWithHtml('<p><em>[Smart Text inserted]</em></p>');
        editor.focus();
      });
    }

    // -------------------------
    // HTML mode toggle
    // -------------------------
    const btnHtml = document.querySelector('.btn-html-mode');
    let htmlMode = false;
    let htmlArea = null;
    if (btnHtml) {
      btnHtml.addEventListener('click', (ev) => {
        ev.preventDefault();
        htmlMode = !htmlMode;
        const wrapper = document.querySelector('.editor-wrapper') || editor.parentElement;
        if (htmlMode) {
          if (!htmlArea) {
            htmlArea = document.createElement('textarea');
            htmlArea.className = 'html-textarea';
            htmlArea.style.minHeight = '220px';
            wrapper.appendChild(htmlArea);
          }
          htmlArea.value = editor.innerHTML;
          editor.style.display = 'none';
          htmlArea.style.display = 'block';
          htmlArea.focus();
        } else {
          if (htmlArea) {
            editor.innerHTML = htmlArea.value;
            htmlArea.style.display = 'none';
          }
          editor.style.display = '';
          editor.focus();
        }
      });
    }

    // -------------------------
    // Voice input (Web Speech API)
    // -------------------------
    const btnVoice = document.querySelector('.btn-voice');
    let recognition = null;
    if (btnVoice && ( 'SpeechRecognition' in window || 'webkitSpeechRecognition' in window )) {
      const SpeechRec = window.SpeechRecognition || window.webkitSpeechRecognition;
      recognition = new SpeechRec();
      recognition.lang = 'en-US';
      recognition.interimResults = false;
      recognition.maxAlternatives = 1;
      recognition.addEventListener('result', (e) => {
        const text = Array.from(e.results).map(r => r[0].transcript).join('');
        replaceSelectionWithHtml(text);
        editor.focus();
      });
      recognition.addEventListener('end', () => btnVoice.classList.remove('listening'));
      btnVoice.addEventListener('click', (ev) => {
        ev.preventDefault();
        if (btnVoice.classList.contains('listening')) {
          recognition.stop();
          btnVoice.classList.remove('listening');
        } else {
          try {
            recognition.start();
            btnVoice.classList.add('listening');
          } catch (err) {
            console.error('[OUTLOOK-EDITOR] recognition start error', err);
            btnVoice.classList.remove('listening');
          }
        }
      });
    } else if (btnVoice) {
      btnVoice.title = 'Voice not supported in this browser';
      btnVoice.style.opacity = '0.5';
      btnVoice.addEventListener('click', () => alert('Speech recognition not supported in this browser.'));
    }

    // -------------------------
    // Focus/blur cleanup
    // -------------------------
    document.addEventListener('click', (ev) => {
      if (!ev.target.closest('.color-picker-wrapper')) {
        document.querySelectorAll('.color-dropdown').forEach(dd => dd.classList.remove('open'));
      }
    });
    editor.addEventListener('blur', () => {
      document.querySelectorAll('.color-dropdown').forEach(dd => dd.classList.remove('open'));
      if (tablePopup) tablePopup.classList.add('table-grid-popup-hidden');
    });

    // small API
    editor.outlookToolbar = editor.outlookToolbar || {};
    editor.outlookToolbar.getHtml = () => editor.innerHTML;
    editor.outlookToolbar.setHtml = (html) => { editor.innerHTML = html; };
    editor.outlookToolbar.toggleHtmlMode = () => { btnHtml && btnHtml.click(); };

    // accessibility for color swatches
    document.querySelectorAll('.color-swatch').forEach(sw => {
      sw.tabIndex = 0;
      sw.addEventListener('keydown', (ev) => {
        if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); sw.click(); }
      });
    });

    // initial hide popups
    document.querySelectorAll('.color-dropdown').forEach(dd => dd.classList.remove('open'));
    if (tablePopup) tablePopup.classList.add('table-grid-popup-hidden');

    console.info('[OUTLOOK-EDITOR] ready');
  } // init
})();
</script>  

 
