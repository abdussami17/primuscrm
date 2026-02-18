<!-- Notifications Tab -->
<div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
    <div class="primus-crm-content-header">
        <h2 class="primus-crm-content-title">Notification Preferences</h2>
        <p class="primus-crm-content-description">Configure system notification
            settings and delivery channels for real-time alerts and reminders.
        </p>
    </div>

    <!-- Customer Notifications -->
    <div class="primus-crm-settings-section">
        <h3 class="primus-crm-section-title">
            <span class="primus-crm-section-icon"><i class="fas fa-user"></i></span>
            Customer Notifications
        </h3>

        <!-- Lead Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">New Internet Lead Received
                </div>
                <div class="primus-crm-setting-desc">Alert when a new internet
                    lead is received in the system</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Lead Assigned to You</div>
                <div class="primus-crm-setting-desc">Notify when a lead is
                    assigned to you</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Lead Reassigned to You
                </div>
                <div class="primus-crm-setting-desc">Alert when a lead is
                    reassigned to you from another user</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Communication Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">New Chat Deal</div>
                <div class="primus-crm-setting-desc">Notify when a new chat deal
                    is initiated</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Incoming Call (Assigned
                    Lead)</div>
                <div class="primus-crm-setting-desc">Alert for incoming calls
                    from assigned leads</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Incoming Text</div>
                <div class="primus-crm-setting-desc">Notify when a new text
                    message is received</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Incoming Email</div>
                <div class="primus-crm-setting-desc">Alert when a new email is
                    received</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Email Engagement Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Customer Viewed Your Email
                </div>
                <div class="primus-crm-setting-desc">Notify when a customer
                    views your sent email</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Customer Replied to Your
                    Email</div>
                <div class="primus-crm-setting-desc">Alert when a customer
                    replies to your email</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Customer Clicked Link in
                    Email</div>
                <div class="primus-crm-setting-desc">Notify when a customer
                    clicks a link in your email</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Delivery Failure Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Text Message Delivery
                    Failure</div>
                <div class="primus-crm-setting-desc">Alert when a text message
                    fails to deliver</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Email Delivery
                    Failure/Bounce</div>
                <div class="primus-crm-setting-desc">Notify when an email fails
                    to deliver or bounces</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Appointment Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">New Appointment Assigned
                </div>
                <div class="primus-crm-setting-desc">Notify when a new
                    appointment is assigned to you</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Starting Now
                </div>
                <div class="primus-crm-setting-desc">Alert when an appointment
                    is starting immediately</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Task Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">New Task Assigned</div>
                <div class="primus-crm-setting-desc">Notify when a new task is
                    assigned to you</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Sales Status Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Lead Moved to New Sales
                    Status</div>
                <div class="primus-crm-setting-desc">Alert when lead status
                    changes (Uncontacted, Attempted, Contacted, Demo, Write-Up,
                    etc.)</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Lead Moved to Pending F&I
                </div>
                <div class="primus-crm-setting-desc">Notify when a lead is moved
                    to Pending F&I status</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Deal Status Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Deal Moved to Sold</div>
                <div class="primus-crm-setting-desc">Alert when a deal is marked
                    as Sold</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Deal Moved to Delivered
                </div>
                <div class="primus-crm-setting-desc">Notify when a deal is
                    marked as Delivered</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Deal Moved to Lost</div>
                <div class="primus-crm-setting-desc">Alert when a deal is marked
                    as Lost</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Service Appointment Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Service Appointment Booked
                </div>
                <div class="primus-crm-setting-desc">Notify when a service
                    appointment is booked</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Service Appointment Closed
                </div>
                <div class="primus-crm-setting-desc">Alert when a service
                    appointment is closed</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- AI & System Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Wishlist</div>
                <div class="primus-crm-setting-desc">Notify about wishlist
                    activities</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">AI Recommendation Available
                </div>
                <div class="primus-crm-setting-desc">Alert when AI
                    recommendations are ready for review</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Duplicate Deal</div>
                <div class="primus-crm-setting-desc">Notify when a potential
                    duplicate deal is detected</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>
    </div>

    <!-- Manager Notifications -->
    <div class="primus-crm-settings-section">
        <h3 class="primus-crm-section-title">
            <span class="primus-crm-section-icon"><i class="fas fa-user-tie"></i></span>
            Manager Notifications
        </h3>

        <!-- Appointment Status Notifications for Managers -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Cancelled</div>
                <div class="primus-crm-setting-desc">Alert managers when
                    appointments are cancelled</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Rescheduled
                </div>
                <div class="primus-crm-setting-desc">Notify managers when
                    appointments are rescheduled</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Missed</div>
                <div class="primus-crm-setting-desc">Alert managers when
                    appointments are missed</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment No Show</div>
                <div class="primus-crm-setting-desc">Notify managers when
                    customers don't show for appointments</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Completed</div>
                <div class="primus-crm-setting-desc">Alert managers when
                    appointments are completed</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Updated</div>
                <div class="primus-crm-setting-desc">Notify managers when
                    appointments are updated (time/date/vehicle/etc.)</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">New Appointment Assigned
                    (Manager)</div>
                <div class="primus-crm-setting-desc">Notify managers when new
                    appointments are assigned</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Starting Now
                    (Manager)</div>
                <div class="primus-crm-setting-desc">Alert managers when
                    appointments are starting immediately</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item" data-channel="email" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Sales Status Deal Moved
                    Backwards in the Funnel</div>
                <div class="primus-crm-setting-desc">Alert managers when deals
                    regress in the sales funnel</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Service Appointment Booked
                    (Manager)</div>
                <div class="primus-crm-setting-desc">Notify managers when
                    service appointments are booked</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Service Appointment Closed
                    (Manager)</div>
                <div class="primus-crm-setting-desc">Alert managers when service
                    appointments are closed</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Inventory Notifications -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Vehicle Added to Inventory
                </div>
                <div class="primus-crm-setting-desc">Notify managers when new
                    vehicles are added to inventory</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Vehicle Price Change</div>
                <div class="primus-crm-setting-desc">Alert managers when vehicle
                    prices are changed</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Wishlist for Managers -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Wishlist (Manager)</div>
                <div class="primus-crm-setting-desc">Notify managers about
                    wishlist activities</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Automation Failed -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Automation Failed (Error)
                </div>
                <div class="primus-crm-setting-desc">Notify managers when
                    automation processes fail</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- AI Recommendation for Managers -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">AI Recommendation Available
                    (Manager)</div>
                <div class="primus-crm-setting-desc">Alert managers when AI
                    recommendations are ready for review</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Duplicate Deal for Managers -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Duplicate Deal (Manager)
                </div>
                <div class="primus-crm-setting-desc">Notify managers when a
                    potential duplicate deal is detected</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <!-- Campaign Completed -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Campaign Completed</div>
                <div class="primus-crm-setting-desc">Alert managers when
                    marketing campaigns are completed</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>
    </div>

    <!-- Reminder Settings -->
    <div class="primus-crm-settings-section">
        <h3 class="primus-crm-section-title">
            <span class="primus-crm-section-icon"><i class="fas fa-clock"></i></span>
            Reminder Settings
        </h3>

        <!-- Sales Appointment Reminder -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Reminder
                    (Sales)</div>
                <div class="primus-crm-setting-desc">Get reminders before sales
                    appointments</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-form-group">
            <label class="primus-crm-form-label">Sales Appointment Reminder
                Time</label>
            <select class="primus-crm-form-control">
                <option value="15">15 Minutes before appointment</option>
                <option value="30" selected>30 Minutes before appointment
                </option>
                <option value="45">45 Minutes before appointment</option>
                <option value="60">60 Minutes before appointment</option>
                <option value="120">120 Minutes before appointment</option>
            </select>
        </div>

        <!-- Service Appointment Reminder -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Appointment Reminder
                    (Service)</div>
                <div class="primus-crm-setting-desc">Get reminders before
                    service appointments</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-form-group">
            <label class="primus-crm-form-label">Service Appointment Reminder
                Time</label>
            <select class="primus-crm-form-control">
                <option value="15">15 Minutes before appointment</option>
                <option value="30" selected>30 Minutes before appointment
                </option>
                <option value="45">45 Minutes before appointment</option>
                <option value="60">60 Minutes before appointment</option>
                <option value="120">120 Minutes before appointment</option>
            </select>
        </div>

        <!-- Task Overdue Reminder -->
        <div class="primus-crm-setting-row">
            <div class="primus-crm-setting-info">
                <div class="primus-crm-setting-name">Task Overdue Reminder</div>
                <div class="primus-crm-setting-desc">Get reminders for overdue
                    tasks (excludes appointment tasks)</div>
                <div class="primus-crm-delivery-channels">
                    <div class="primus-crm-channel-item active" data-channel="email"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="primus-crm-channel-label">Email</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="app" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="primus-crm-channel-label">App</div>
                    </div>
                    <div class="primus-crm-channel-item" data-channel="text" onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="primus-crm-channel-label">Text</div>
                    </div>
                    <div class="primus-crm-channel-item active" data-channel="desktop"
                        onclick="toggleChannel(this)">
                        <div class="primus-crm-channel-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="primus-crm-channel-label">Desktop</div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-toggle-switch active" onclick="toggleNotification(this)"></div>
        </div>

        <div class="primus-crm-form-group">
            <label class="primus-crm-form-label">Task Overdue Reminder
                Time</label>
            <select class="primus-crm-form-control">
                <option value="15">15 Minutes after overdue</option>
                <option value="30" selected>30 Minutes after overdue</option>
                <option value="45">45 Minutes after overdue</option>
                <option value="60">60 Minutes after overdue</option>
                <option value="120">120 Minutes after overdue</option>
            </select>
        </div>
    </div>

    <!-- Save Button -->
    <div class="primus-crm-settings-actions">
        <button id="saveNotificationBtn" type="button" class="primus-crm-btn primus-crm-btn-primary">Save Notification Preferences</button>
        <button id="resetNotificationBtn" type="button" class="primus-crm-btn primus-crm-btn-secondary">Reset to Defaults</button>
    </div>

    <script>
        (function(){
            function collectPreferences() {
                const preferences = [];
                document.querySelectorAll('#notifications .primus-crm-setting-row').forEach(row => {
                    const nameEl = row.querySelector('.primus-crm-setting-name');
                    if (!nameEl) return;
                    const name = nameEl.textContent.trim();
                    const enabled = !!row.querySelector('.primus-crm-toggle-switch')?.classList.contains('active');
                    const channels = {};
                    row.querySelectorAll('.primus-crm-channel-item').forEach(ch => {
                        const key = ch.getAttribute('data-channel');
                        channels[key] = ch.classList.contains('active');
                    });
                    preferences.push({ name, enabled, channels });
                });

                const selects = document.querySelectorAll('#notifications .primus-crm-form-group select');
                const reminders = {
                    salesAppointmentReminder: selects[0] ? selects[0].value : null,
                    serviceAppointmentReminder: selects[1] ? selects[1].value : null,
                    taskOverdueReminder: selects[2] ? selects[2].value : null,
                };

                return { notifications: preferences, reminders };
            }

            async function savePreferencesAjax() {
                const payload = collectPreferences();
                try {
                    const res = await fetch('/settings/notifications', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ data: payload })
                    });
                    const json = await res.json();
                    if (json && json.success) {
                        if (typeof showToast === 'function') showToast('Notification preferences saved', 'success');
                    } else {
                        if (typeof showToast === 'function') showToast('Failed to save', 'error');
                    }
                } catch (err) {
                    console.error('Failed to save notification settings', err);
                    if (typeof showToast === 'function') showToast('Error saving settings', 'error');
                }
            }

            function applyDefaults() {
                // default: enable toggles and enable email/app/desktop
                document.querySelectorAll('#notifications .primus-crm-toggle-switch').forEach(t => {
                    t.classList.add('active');
                    t.closest('.primus-crm-setting-row')?.classList.add('notification-enabled');
                });
                document.querySelectorAll('#notifications .primus-crm-channel-item').forEach(ch => {
                    const type = ch.getAttribute('data-channel');
                    const should = (type === 'email' || type === 'app' || type === 'desktop');
                    ch.classList.toggle('active', should);
                });
                // reminders reset to 30
                document.querySelectorAll('#notifications .primus-crm-form-group select').forEach((s, i) => { s.value = '30'; });
            }

            async function loadNotificationSettings() {
                try {
                    const res = await fetch('/settings/notifications', { headers: { Accept: 'application/json' } });
                    if (!res.ok) return;
                    const json = await res.json();
                    const data = json.data || {};

                    // Apply notification rows
                    const map = {};
                    if (Array.isArray(data.notifications)) {
                        data.notifications.forEach(n => { if (n && n.name) map[n.name.trim()] = n; });
                    }

                    document.querySelectorAll('#notifications .primus-crm-setting-row').forEach(row => {
                        const nameEl = row.querySelector('.primus-crm-setting-name');
                        if (!nameEl) return;
                        const name = nameEl.textContent.trim();
                        const saved = map[name];
                        if (saved) {
                            const toggle = row.querySelector('.primus-crm-toggle-switch');
                            if (toggle) toggle.classList.toggle('active', !!saved.enabled);
                            if (toggle) row.classList.toggle('notification-enabled', !!saved.enabled);
                            row.querySelectorAll('.primus-crm-channel-item').forEach(ch => {
                                const key = ch.getAttribute('data-channel');
                                const val = saved.channels && typeof saved.channels[key] !== 'undefined' ? !!saved.channels[key] : ch.classList.contains('active');
                                ch.classList.toggle('active', val);
                            });
                        }
                    });

                    // apply reminders
                    const selects = document.querySelectorAll('#notifications .primus-crm-form-group select');
                    if (data.reminders) {
                        if (selects[0] && data.reminders.salesAppointmentReminder) selects[0].value = data.reminders.salesAppointmentReminder;
                        if (selects[1] && data.reminders.serviceAppointmentReminder) selects[1].value = data.reminders.serviceAppointmentReminder;
                        if (selects[2] && data.reminders.taskOverdueReminder) selects[2].value = data.reminders.taskOverdueReminder;
                    }
                } catch (err) {
                    console.error('Failed to load notification settings', err);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // hook buttons
                const saveBtn = document.getElementById('saveNotificationBtn');
                const resetBtn = document.getElementById('resetNotificationBtn');
                if (saveBtn) saveBtn.addEventListener('click', savePreferencesAjax);
                if (resetBtn) resetBtn.addEventListener('click', function(){ if (confirm('Reset notification preferences to defaults?')) { applyDefaults(); savePreferencesAjax(); } });

                loadNotificationSettings();
            });
        })();
    </script>
</div>
