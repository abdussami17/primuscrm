<style>
    .editor img.selected {
        outline: 3px solid #8b5cf6;
        outline-offset: 2px
    }
    
    .device-toggle button i {
        font-size: 16px
    }
    
    
    .device-toggle button {
        border-radius: 6px;
        padding: 2px 6px;
        border: none;
        background: #fff;
        outline: none;
    
    }
    
    /* Mobile view */
    .preview-content.mobile {
        max-width: 375px;
        margin: 0 auto;
        border-left: 1px solid #e1e5eb;
        border-right: 1px solid #e1e5eb;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .image-controls {
        position: fixed;
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        z-index: 1000;
        display: none;
        min-width: 280px
    }
    
    .image-controls.show {
        display: block
    }
    
    /* ... rest of image control styles ... */
    :root {
        --primary-color: rgb(0, 33, 64);
        --primary-light: rgba(0, 33, 64, 0.1);
        --primary-dark: rgb(0, 25, 48);
        --surface: #ffffff;
        --muted: #6b7280;
        --ring: #e5e7eb;
        --bg: #f8fafc;
    }
    
    .toolbar-btn.active {
        background-color: #e9ecef !important;
        border-color: #6c757d !important;
        color: #495057 !important;
    }
    
    .toolbar-btn.active:hover {
        background-color: #dee2e6 !important;
    }
    
    .button-group button {
        font-size: 12px !important;
        padding: 6px 10px !important;
    }
    
    * {
        box-sizing: border-box;
    }
    
    html,
    body {
        height: 100%;
    
        font-family: "Inter";
    }
    
    .app {
        min-height: 100vh;
    }
    
    .card {
        border: none;
        box-shadow: none;
        background: white;
    }
    
    .template-header {
        position: static;
        top: 0;
        background: var(--surface);
        z-index: 30;
        border-bottom: 1px solid var(--ring);
    }
    
    .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-dark) !important;
        border-color: var(--primary-dark) !important;
    }
    
    .btn-ai {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .btn-ai:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }
    
    .outlook-toolbar {
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 6px 6px 0 0;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }
    
    .toolbar-separator {
        width: 1px;
        height: 24px;
        background: #d1d5db;
        margin: 0 4px;
    }
    
    p {
        margin-bottom: 0px !important;
    }
    
    .toolbar-btn {
        width: 32px;
        height: 32px;
        border: 1px solid transparent;
        background: transparent;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        font-size: 16px;
        color: #374151;
        position: relative;
    }
    
    /* .toolbar-btn:hover {
        background: #e5e7eb;
        border-color: #d1d5db;
      }
      .toolbar-btn.active {
        background: #dbeafe;
        border-color: #3b82f6;
        color: #1e40af;
      }
       */
    .toolbar-select {
        height: 32px;
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 13px;
        min-width: 80px;
        cursor: pointer;
    }
    
    .btn-smart-text {
        height: 32px;
        padding: 0 12px;
        border: 1px solid #8b5cf6;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    
    .btn-smart-text:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }
    
    .color-picker-wrapper {
        position: relative;
    }
    
    .color-picker-btn {
        width: 32px;
        height: 32px;
        border: 1px solid transparent;
        background: transparent;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.15s ease;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .color-picker-btn:hover {
        background: #e5e7eb;
        border-color: #d1d5db;
    }
    
    .color-underline {
        position: absolute;
        bottom: 4px;
        left: 8px;
        right: 8px;
        height: 3px;
        border-radius: 1px;
    }
    
    .color-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        padding: 12px;
        display: none;
        z-index: 1000;
        min-width: 220px;
    }
    
    .color-dropdown.show {
        display: block;
    }
    
    .color-grid {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        gap: 4px;
        margin-bottom: 8px;
    }
    
    .color-swatch {
        width: 20px;
        height: 20px;
        border: 1px solid #d1d5db;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    
    .color-swatch:hover {
        transform: scale(1.15);
        border-color: #374151;
    }
    
    .custom-color-section {
        border-top: 1px solid #e5e7eb;
        padding-top: 8px;
        margin-top: 8px;
    }
    
    .custom-color-btn {
        width: 100%;
        padding: 6px 12px;
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s ease;
    }
    
    .custom-color-btn:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }
    
    .custom-color-inputs {
        display: none;
        margin-top: 8px;
        padding: 8px;
        background: #f9fafb;
        border-radius: 4px;
    }
    
    .custom-color-inputs.show {
        display: block;
    }
    
    .color-input-row {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .color-input-row:last-child {
        margin-bottom: 0;
    }
    
    .color-input-group {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .color-input-label {
        font-size: 11px;
        color: #6b7280;
        min-width: 30px;
    }
    
    .color-input {
        width: 60px;
        height: 28px;
        border: 1px solid #d1d5db;
        border-radius: 3px;
        padding: 2px 6px;
        font-size: 12px;
        font-family: 'Courier New', monospace;
    }
    
    .color-preview-box {
        width: 40px;
        height: 28px;
        border: 1px solid #d1d5db;
        border-radius: 3px;
    }
    
    .table-grid-popup {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        padding: 12px;
        display: none;
        z-index: 1000;
    }
    
    .table-grid-popup.show {
        display: block;
    }
    
    .table-grid {
        display: grid;
        grid-template-columns: repeat(10, 20px);
        gap: 2px;
        margin-bottom: 8px;
    }
    
    .table-cell {
        width: 20px;
        height: 20px;
        border: 1px solid #d1d5db;
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.1s ease;
    }
    
    .table-cell:hover,
    .table-cell.selected {
        background: #3b82f6;
        border-color: #2563eb;
    }
    
    .table-size-label {
        font-size: 12px;
        color: #6b7280;
        text-align: center;
    }
    
    .editor-wrapper {
        border: 1px solid #d1d5db;
        border-radius: 0 0 6px 6px;
        border-top: none;
        background: white;
        position: relative;
    }
    
    .editor-container {
        height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .editor {
        min-height: 100%;
        outline: none;
        padding: 20px;
        background: white;
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.6;
        word-wrap: break-word;
    }
    
    .editor img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 10px 0;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .editor table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
        border: 1px solid #d1d5db;
    }
    
    .editor table th,
    .editor table td {
        border: 1px solid #d1d5db;
        padding: 8px 12px;
        text-align: left;
    }
    
    .editor table th {
        /* background-color: #f3f4f6; */
        /* font-weight: 600; */
    }
    
    .token {
    
        display: inline-block;
    
    }
    
    .cta-button {
        display: inline-block;
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        margin: 10px 0;
        text-align: center;
        transition: all 0.2s ease;
    }
    
    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 33, 64, 0.3);
    }
    
    .voice-btn {
        width: 32px;
        height: 32px;
        border: 1px solid transparent;
        background: transparent;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
        color: #dc2626;
    }
    
    .voice-btn:hover {
        background: #fee2e2;
        border-color: #fecaca;
    }
    
    .voice-btn.recording {
        background: #dc2626;
        color: white;
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
    
        0%,
        100% {
            opacity: 1;
        }
    
        50% {
            opacity: 0.7;
        }
    }
    
    .ai-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }
    
    .ai-modal.show {
        display: flex;
    }
    
    .ai-modal-content {
        background: white;
        border-radius: 12px;
        max-width: 700px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    
    .ai-modal-header {
        background: rgb(0, 33, 64);
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .ai-modal-body {
        padding: 24px;
    }
    
    .preview-content .token {
        background: transparent;
        color: #000;
        padding: 0 !important;
        border-radius: 0;
        font-size: inherit !important;
        border: none !important;
        display: inline-block;
        margin: 0 0px;
        cursor: text;
    }
    
    .ai-option-card {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .ai-option-card:hover {
        border-color: rgb(0, 33, 64);
        background: #f5f5f5;
        transform: translateY(-2px);
    }
    
    .ai-option-icon {
        width: 48px;
        height: 48px;
        background: rgb(0, 33, 64);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin-bottom: 12px;
    }
    
    .ai-input-section {
        display: none;
    }
    
    .ai-input-section.show {
        display: block;
    }
    
    .ai-textarea {
        width: 100%;
        min-height: 120px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        font-size: 14px;
        resize: vertical;
        transition: all 0.2s ease;
    }
    
    .ai-textarea:focus {
        outline: none;
        border-color: rgb(0, 33, 64);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    .ai-generating {
        text-align: center;
        padding: 40px 20px;
        display: none;
    }
    
    .ai-generating.show {
        display: block;
    }
    
    .ai-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid #ede9fe;
        border-top-color: rgb(0, 33, 64);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    .template-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }
    
    .template-card {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }
    
    .template-card:hover {
        border-color: rgb(0, 33, 64);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
    }
    
    .template-preview {
        width: 100%;
        height: 120px;
        background: #f3f4f6;
        border-radius: 6px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: rgb(0, 33, 64);
    }
    
    .merge-fields-container {
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .merge-fields-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 16px;
        font-weight: 600;
        font-size: 15px;
    }
    
    .category-header {
        background: #f9fafb;
        padding: 10px 16px;
        border-bottom: 1px solid #e5e7eb;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        color: #374151;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.15s ease;
    }
    
    .category-header:hover {
        background: #f3f4f6;
    }
    
    .category-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .category-body.show {
        max-height: 2000px;
    }
    
    .field-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        border-bottom: 1px solid #f3f4f6;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    
    .field-item:hover {
        background: #f9fafb;
        padding-left: 20px;
    }
    
    .field-label {
        font-size: 13px;
        color: #374151;
    }
    
    .field-tag {
        background: var(--primary-color);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-family: 'Courier New', monospace;
    }
    
    .preview-container {
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .preview-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 16px;
    }
    
    .preview-content {
        padding: 20px;
        min-height: 400px;
        font-family: Arial, sans-serif;
    }
    
    @media (max-width: 768px) {
        .outlook-toolbar {
            overflow-x: auto;
        }
    }
    
    
    
    </style>