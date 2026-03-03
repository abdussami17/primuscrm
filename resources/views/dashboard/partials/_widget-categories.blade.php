        <div id="widgetContainer" class="mb-4">
            <div class="col-12">
                <!-- Category Buttons -->
                <div class="crm-header-widget d-flex  mb-3">
                    <div class="category-btn active" data-category="lead">Lead Activity Metrics <i
                            class="ti ti-caret-down-filled"></i></div>
                    <div class="category-btn" data-category="outcome">Outcome Metrics <i
                            class="ti ti-caret-down-filled"></i>
                    </div>
                    <div class="category-btn" data-category="favourites">Favourite Metrics <i
                            class="ti ti-caret-down-filled"></i></div>

                    <!-- Color Settings Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="colorSettingsBtn"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            🎨 Widget Colors
                        </button>
                        <ul class="dropdown-menu p-3" aria-labelledby="colorSettingsBtn" style="min-width:220px;">
                            <li class="mb-2">
                                <label class="form-label">Border Color</label>
                                <input type="color" id="borderColorPicker" class="form-control form-control-color"
                                    value="#000000">
                            </li>
                            <li class="mb-2">
                                <label class="form-label">Background Color</label>
                                <input type="color" id="bgColorPicker" class="form-control form-control-color"
                                    value="#ffffff">
                            </li>
                            <li class="d-flex gap-2 mt-3">
                                <button id="resetColorsBtn" class="btn btn-light border border-1 flex-fill">Reset</button>
                                <button id="saveColorsBtn" class="btn btn-primary flex-fill">Save</button>

                            </li>

                        </ul>
                    </div>
                </div>
                <!-- Modal -->

                <!-- Lead Activity Widgets -->
                <div class="widgets-area category-lead active">