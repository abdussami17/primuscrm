 <div class="modal fade" id="duplicateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Merge records: <span id="stepTitle">Step 1 of 3 - Choose Main Record</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active" id="step1">1</div>
                        <div class="step-line" id="line1"></div>
                        <div class="step" id="step2">2</div>
                        <div class="step-line" id="line2"></div>
                        <div class="step" id="step3">3</div>
                    </div>

                    <!-- Step 1: Choose Main Record -->
                    <div id="step1Content" class="step-content">
                        <div class="step-title">Which record do you want to keep?</div>

                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Search customers..."
                                id="searchInput1">
                            <i class="fas fa-search search-icon"></i>
                        </div>

                        <div id="customerList1" class="customer-list"></div>
                    </div>

                    <!-- Step 2: Choose Duplicate -->
                    <div id="step2Content" class="step-content" style="display: none;">
                        <div class="step-title">Which duplicate record do you want to merge?</div>

                        <div class="selected-customer">
                            <h6 class="mb-3">Selected Main Record:</h6>
                            <div id="selectedMainCustomer"></div>
                        </div>

                        <div class="search-container">
                            <input type="text" class="search-input" placeholder="Search customers..."
                                id="searchInput2">
                            <i class="fas fa-search search-icon"></i>
                        </div>

                        <div id="customerList2" class="customer-list"></div>
                    </div>

                    <!-- Step 3: Confirm Merge -->
                    <div id="step3Content" class="step-content" style="display: none;">
                        <div class="step-title">Confirm Merge</div>

                        <div class="merge-comparison-container">
                            <!-- Header Row -->
                            <div class="merge-comparison-row header-row">
                                <div class="field-label-col">Field</div>
                                <div class="record-col">
                                    <div class="record-header main-header">
                                        <span class="record-badge main-badge">MAIN RECORD</span>
                                        <div class="record-id">ID # <span id="mainRecordId"></span></div>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="record-header duplicate-header">
                                        <span class="record-badge duplicate-badge">DUPLICATE RECORD</span>
                                        <div class="record-id">ID # <span id="duplicateRecordId"></span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- First Name Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">First Name</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="firstName" value="main" checked>
                                        <span class="field-value" id="mainFirstName"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="firstName" value="duplicate">
                                        <span class="field-value" id="duplicateFirstName"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle Name Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">Middle Name</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="middleName" value="main" checked>
                                        <span class="field-value" id="mainMiddleName"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="middleName" value="duplicate">
                                        <span class="field-value" id="duplicateMiddleName"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Last Name Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">Last Name</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="lastName" value="main" checked>
                                        <span class="field-value" id="mainLastName"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="lastName" value="duplicate">
                                        <span class="field-value" id="duplicateLastName"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Physical Address Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">Physical Address</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="address" value="main" checked>
                                        <span class="field-value" id="mainAddress"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="address" value="duplicate">
                                        <span class="field-value" id="duplicateAddress"></span>
                                        <span class="invalid-indicators" id="duplicateAddressIssues"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Number Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">Mobile Number</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="mobile" value="main" checked>
                                        <span class="field-value" id="mainMobile"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="mobile" value="duplicate">
                                        <span class="field-value" id="duplicateMobile"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Home Number Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">Home Number</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="home" value="main" checked>
                                        <span class="field-value" id="mainHome"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="home" value="duplicate">
                                        <span class="field-value" id="duplicateHome"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Work Number Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">Work Number</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="work" value="main" checked>
                                        <span class="field-value" id="mainWork"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="work" value="duplicate">
                                        <span class="field-value" id="duplicateWork"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Row -->
                            <div class="merge-comparison-row">
                                <div class="field-label-col">Email</div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="email" value="main" checked>
                                        <span class="field-value" id="mainEmail"></span>
                                    </div>
                                </div>
                                <div class="record-col">
                                    <div class="field-value-wrapper">
                                        <input type="radio" name="email" value="duplicate">
                                        <span class="field-value" id="duplicateEmail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loadingContent" class="step-content text-center" style="display: none;">
                        <div class="loading-spinner"></div>
                        <span>Merging records...</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-go-back" id="goBackBtn" style="display: none;">GO
                        BACK</button>
                    <button type="button" class="btn-merge" id="mergeBtn" style="display: none;">MERGE
                        RECORDS</button>
                </div>
            </div>
        </div>
    </div>