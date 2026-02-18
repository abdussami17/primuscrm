{{-- Email Editor with Toolbar --}}
<div class="card p-0 mb-4">
    <div class="outlook-toolbar">
        {{-- Font Family --}}
        <select class="toolbar-select" id="fontFamily" title="Font family">
            <option value="Arial">Arial</option>
            <option value="Times New Roman">Times New Roman</option>
            <option value="Helvetica">Helvetica</option>
            <option value="Georgia">Georgia</option>
            <option value="Verdana">Verdana</option>
            <option value="Courier New">Courier New</option>
        </select>

        {{-- Font Size --}}
        <select class="toolbar-select" id="fontSize" title="Font size">
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
            <button type="button" class="color-picker-btn" id="textColorBtn" title="Text color">
                <i class="bi bi-fonts" style="font-size: 18px;"></i>
                <div class="color-underline" id="textColorIndicator" style="background: #000000;"></div>
            </button>
            <div class="color-dropdown" id="textColorDropdown"></div>
        </div>

        {{-- Highlight Color --}}
        <div class="color-picker-wrapper">
            <button type="button" class="color-picker-btn" id="highlightColorBtn" title="Highlight color">
                <i class="bi bi-highlighter"></i>
                <div class="color-underline" id="highlightColorIndicator" style="background: #ffff00;"></div>
            </button>
            <div class="color-dropdown" id="highlightColorDropdown"></div>
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
            <button type="button" class="toolbar-btn" id="btnTable" title="Insert table">
                <i class="bi bi-table"></i>
            </button>
            <div class="table-grid-popup" id="tableGridPopup">
                <div class="table-grid" id="tableGrid"></div>
                <div class="table-size-label" id="tableSizeLabel">1 x 1 Table</div>
            </div>
        </div>

        <button type="button" class="toolbar-btn" id="btnImage" title="Insert image">
            <i class="bi bi-image"></i>
        </button>

        <button type="button" class="toolbar-btn" id="btnLink" title="Insert link">
            <i class="bi bi-link-45deg"></i>
        </button>

        <button type="button" class="toolbar-btn" id="btnAttach" title="Attach file">
            <i class="bi bi-paperclip"></i>
        </button>

        <button type="button" class="toolbar-btn" id="btnClearFormat" title="Clear formatting">
            <i class="bi bi-eraser"></i>
        </button>

        <div class="toolbar-separator"></div>

        {{-- Smart Text --}}
        <button type="button" class="toolbar-btn" id="btnSmartText" title="Smart Text - Enhance with AI">
            <i class="bi bi-magic"></i>
        </button>

        <div class="toolbar-separator"></div>

        {{-- HTML Edit Mode --}}
        <button type="button" class="toolbar-btn" id="btnHtmlMode" title="Edit HTML / Switch to HTML mode">
            <i class="bi bi-code-slash"></i>
        </button>

        {{-- Voice Input --}}
        <button type="button" class="voice-btn" id="btnVoice" title="Voice to text">
            <i class="bi bi-mic-fill"></i>
        </button>
    </div>

    {{-- HTML Textarea (Hidden by default) --}}
    <textarea class="html-textarea" id="htmlTextarea" style="display:none; width:100%; height:400px; padding:12px; font-family:monospace; font-size:12px; border:2px solid #002140; background:#f8f9fa;"></textarea>

    {{-- WYSIWYG Editor --}}
    <div class="editor-wrapper">
        <div class="editor-container">
            <div class="editor" id="editor" contenteditable="true">
                <p>Hi <span class="token">@{{first_name}}</span>,</p>
                <p>Welcome to <span class="token">@{{dealer_name}}</span>! We're excited to help you find your perfect vehicle.</p>
                <p>If you have any questions, please don't hesitate to contact me.</p>
                <p>Best regards,<br><br>
                    <span class="token">@{{advisor_name}}</span><br>
                    <span class="token">@{{dealer_name}}</span><br>
                    Phone: <span class="token">@{{dealer_phone}}</span>
                </p>
            </div>
        </div>
    </div>
</div>