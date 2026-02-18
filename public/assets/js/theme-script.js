document.addEventListener("DOMContentLoaded", function () {
    const html = document.querySelector("html");
    const darkModeSwitch = document.getElementById("darkModeSwitch");
  
    const defaultThemeConfig = {
      light: {
        "data-layout": "single",
        "data-bs-theme": "light",
        "data-sidebar": "light",
        "data-color": "primary",
        "data-topbar": "white",
        "data-size": "default",
        "data-width": "fluid"
      },
      dark: {
        "data-layout": "single",
        "data-bs-theme": "dark",
        "data-sidebar": "light",
        "data-color": "primary",
        "data-topbar": "white",
        "data-size": "default",
        "data-width": "fluid"
      }
    };
  
    function applyThemeConfig(config) {
      Object.entries(config).forEach(([key, value]) => {
        html.setAttribute(key, value);
        localStorage.setItem(key.replace("data-", ""), value);
      });
  
      // 🔁 Update all logos with .logo-img class
      const logos = document.querySelectorAll(".logo-img");
      logos.forEach(logo => {
        logo.src = config["data-bs-theme"] === "dark"
          ? "assets/dark_logo.png"
          : "assets/light_logo.png";
      });
    }
  
    // Initial load
    const savedDarkMode = localStorage.getItem("darkMode") === "enabled";
    applyThemeConfig(savedDarkMode ? defaultThemeConfig.dark : defaultThemeConfig.light);
    if (darkModeSwitch) darkModeSwitch.checked = savedDarkMode;
  
    // ✅ Real-time toggle
    if (darkModeSwitch) {
      darkModeSwitch.addEventListener("change", function () {
        const isDark = this.checked;
        localStorage.setItem("darkMode", isDark ? "enabled" : "disabled");
        applyThemeConfig(isDark ? defaultThemeConfig.dark : defaultThemeConfig.light);
  
        // Update all other toggles if needed
        document.querySelectorAll("#darkModeSwitch").forEach(el => {
          el.checked = isDark;
        });
      });
    }
  });
  
    
    document.addEventListener("DOMContentLoaded", function() {

    // document.body.insertAdjacentHTML('beforeend', themesettings);

    const darkModeToggle = document.getElementById("dark-mode-toggle");
	const lightModeToggle = document.getElementById("light-mode-toggle");

	// Detect stored mode
	const darkMode = localStorage.getItem("darkMode");

	function enableDarkMode() {
		document.documentElement.setAttribute("data-bs-theme", "dark");
		darkModeToggle?.classList.remove("activate");
		lightModeToggle?.classList.add("activate");
		localStorage.setItem("darkMode", "enabled");
	}

	function disableDarkMode() {
		document.documentElement.setAttribute("data-bs-theme", "light");
		lightModeToggle?.classList.remove("activate");
		darkModeToggle?.classList.add("activate");
		localStorage.setItem("darkMode", "disabled");
	}

	// Initialize on page load
	if (darkMode === "enabled") {
		enableDarkMode();
	} else {
		disableDarkMode();
	}

	// Attach event listeners
	darkModeToggle?.addEventListener("click", enableDarkMode);
	lightModeToggle?.addEventListener("click", disableDarkMode);

        // const themeRadios = document.querySelectorAll('input[name="theme"]');
        const sidebarRadios = document.querySelectorAll('input[name="sidebar"]');
        const colorRadios = document.querySelectorAll('input[name="color"]');
        const layoutRadios = document.querySelectorAll('input[name="LayoutTheme"]');
        const topbarRadios = document.querySelectorAll('input[name="topbar"]');
        const sidebarBgRadios = document.querySelectorAll('input[name="sidebarbg"]');
        const sizeRadios = document.querySelectorAll('input[name="size"]');
        const widthRadios = document.querySelectorAll('input[name="width"]');
        const topbarbgRadios = document.querySelectorAll('input[name="topbarbg"]');
        const resetButton = document.getElementById('resetbutton');
        const sidebarBgContainer = document.getElementById('sidebarbgContainer');
        const sidebarElement = document.querySelector('.sidebar'); // Adjust this selector to match your sidebar element
    
        function setThemeAndSidebarTheme(theme, sidebarTheme, color, layout, topbar, size, width) {
            // Check if the sidebar element exists
            if (!sidebarElement) {
                console.error('Sidebar element not found');
                return;
            }
    
            // Setting data attributes and classes
            document.documentElement.setAttribute('data-bs-theme', theme);
            document.documentElement.setAttribute('data-sidebar', sidebarTheme);
            document.documentElement.setAttribute('data-color', color);
            document.documentElement.setAttribute('data-layout', "single");
            document.documentElement.setAttribute('data-topbar', topbar);
            document.documentElement.setAttribute('data-size', size);
            document.documentElement.setAttribute('data-width', width);
    
            //track mini-layout set or not
            layout_mini = 0;
            if (layout === 'mini') {
                document.body.classList.add("mini-sidebar");
                document.body.classList.remove("menu-horizontal");
                layout_mini = 1;
            }  else if (layout === 'horizontal') {
                document.body.classList.add("menu-horizontal");
                document.body.classList.remove("mini-sidebar");
            } else if (layout === 'horizontal-single') {
                document.body.classList.add("menu-horizontal");
                document.body.classList.remove("mini-sidebar");
            } else if (layout === 'horizontal-overlay') {
                document.body.classList.add("menu-horizontal");
                document.body.classList.remove("mini-sidebar");
            } else {
                document.body.classList.remove("mini-sidebar", "menu-horizontal");
            }

            
            if (size === 'compact') {
                document.body.classList.add("mini-sidebar");
                document.body.classList.remove("expand-menu");
                layout_mini = 1;
            } else if (size === 'hoverview') {
                document.body.classList.add("expand-menu");
                if(layout_mini == 0){ //remove only mini sidebar not set
                    document.body.classList.remove("mini-sidebar");
                }
            }  else  {
                if(layout_mini == 0){ //remove only mini sidebar not set
                    document.body.classList.remove("mini-sidebar");
                }
                document.body.classList.remove("expand-menu");
            }

            if (width === 'box') {
                document.body.classList.add("layout-box-mode");
                document.body.classList.add("mini-sidebar");
                layout_mini = 1;
            }else {
                if(layout_mini == 0){ //remove only mini sidebar not set
                    document.body.classList.remove("mini-sidebar");
                }
                document.body.classList.remove("layout-box-mode");
            }
            if (((width === 'box') && (layout === 'horizontal')) || ((width === 'box') && (layout === 'horizontal-overlay')) ||
            ((width === 'box') && (layout === 'horizontal-single')) || ((width === 'box') && (layout === 'without-header'))) {
                    document.body.classList.remove("mini-sidebar");
            }
            
            // Saving to localStorage
            localStorage.setItem('theme', theme);
            localStorage.setItem('sidebarTheme', sidebarTheme);
            localStorage.setItem('color', color);
            localStorage.setItem('layout', layout);
            localStorage.setItem('topbar', topbar);
            localStorage.setItem('size', size);
            localStorage.setItem('width', width);
    
            // Show/hide sidebar background options based on layout selection
            if (layout === 'box' && sidebarBgContainer) {
                sidebarBgContainer.classList.add('show');
            } else if (sidebarBgContainer) {
                sidebarBgContainer.classList.remove('show');
            }
        }
    
        function handleSidebarBgChange() {
            const sidebarBg = document.querySelector('input[name="sidebarbg"]:checked') ? document.querySelector('input[name="sidebarbg"]:checked').value : null;
    
            if (sidebarBg) {
                document.body.setAttribute('data-sidebarbg', sidebarBg);
                localStorage.setItem('sidebarBg', sidebarBg);
            } else {
                document.body.removeAttribute('data-sidebarbg');
                localStorage.removeItem('sidebarBg');
            }
        }
    
        function handleInputChange() {
           // const theme = 'light'
           const theme = localStorage.getItem('darkMode') === 'enabled' ? 'dark' : 'light';

            const layout = document.querySelector('input[name="LayoutTheme"]:checked').value;
            const size = document.querySelector('input[name="size"]:checked').value;
            const width = document.querySelector('input[name="width"]:checked').value;

            
            color = localStorage.getItem('primaryRGB');
            sidebarTheme = localStorage.getItem('sidebarRGB');
            topbar = localStorage.getItem('topbarRGB');
            
            if(document.querySelector('input[name="color"]:checked') != null)
            {
                color = document.querySelector('input[name="color"]:checked').value;
            }else{
                color = 'all'
            }

            if(document.querySelector('input[name="sidebar"]:checked') != null)
            {
                sidebarTheme = document.querySelector('input[name="sidebar"]:checked').value;
            }else{
                sidebarTheme = 'all'
            }

            if(document.querySelector('input[name="topbar"]:checked') != null)
            {
                topbar = document.querySelector('input[name="topbar"]:checked').value;
            }else{
                topbar = 'all'
            }
    
            setThemeAndSidebarTheme(theme, sidebarTheme, color, layout, topbar, size, width);
        }

      
    
        function resetThemeAndSidebarThemeAndColorAndBg() {
            setThemeAndSidebarTheme('light', 'light', 'primary', 'default', 'white', 'default', 'fluid');
            document.body.removeAttribute('data-sidebarbg');

            // ✅ Set data-bs-theme="light" on <html>
            document.documentElement.setAttribute('data-bs-theme', 'light');

            // ✅ Fix: remove darkMode key from localStorage
            localStorage.removeItem('darkMode');

            document.getElementById('light-mode-toggle')?.classList.remove('activate');
            document.getElementById('dark-mode-toggle')?.classList.add('activate');
            document.getElementById('lightSidebar').checked = true;
            document.getElementById('primaryColor').checked = true;
            document.getElementById('defaultLayout').checked = true;
            document.getElementById('whiteTopbar').checked = true;
            document.getElementById('defaultSize').checked = true;
            document.getElementById('fluidWidth').checked = true;
    
            const checkedSidebarBg = document.querySelector('input[name="sidebarbg"]:checked');
            if (checkedSidebarBg) {
                checkedSidebarBg.checked = false;
            }
    
            localStorage.removeItem('sidebarBg');
        }
    
        // Adding event listeners
        sidebarRadios.forEach(radio => radio.addEventListener('change', handleInputChange));
        colorRadios.forEach(radio => radio.addEventListener('change', handleInputChange));
        layoutRadios.forEach(radio => radio.addEventListener('change', handleInputChange));
        topbarRadios.forEach(radio => radio.addEventListener('change', handleInputChange));
        sizeRadios.forEach(radio => radio.addEventListener('change', handleInputChange));
        widthRadios.forEach(radio => radio.addEventListener('change', handleInputChange));
        sidebarBgRadios.forEach(radio => radio.addEventListener('change', handleSidebarBgChange));
        topbarbgRadios.forEach(radio => radio.addEventListener('change', handleTopbarBgChange));
        document.addEventListener("DOMContentLoaded", function () {
            const resetButton = document.getElementById("resetButton");
            if (resetButton) {
                resetButton.addEventListener("click", resetThemeAndSidebarThemeAndColorAndBg);
            }
        });
        
    
        // Initial setup from localStorage
        const savedTheme = localStorage.getItem('darkMode') === 'enabled' ? 'dark' : 'light';

        savedSidebarTheme = localStorage.getItem('sidebarTheme');
        savedColor = localStorage.getItem('color');
        const savedLayout = localStorage.getItem('layout') || 'default';
        savedTopbar = localStorage.getItem('topbar');
        const savedSize = localStorage.getItem('size') || 'default';
        const savedWidth = localStorage.getItem('width') || 'fluid';
        const savedSidebarBg = localStorage.getItem('sidebarBg') || null;
        const savedTopbarBg = localStorage.getItem('topbarbg') || null;

        // setup theme color all
        const savedColorPickr = localStorage.getItem('primaryRGB') 
        if((savedColor == null) && (savedColorPickr == null))
        {
            savedColor = 'primary';
        }else if((savedColorPickr != null) && (savedColor == null))
        {
            savedColor = 'all';
            let html = document.querySelector("html");
            html.style.setProperty("--primary-rgb",  savedColorPickr);
        }

        // setup theme topbar all
        const savedTopbarPickr = localStorage.getItem('topbarRGB') 
        if((savedTopbar == null) && (savedTopbarPickr == null))
        {
            savedTopbar = 'white';
        }else if((savedTopbarPickr != null) && (savedTopbar == null))
        {
            savedTopbar = 'all';
            let html = document.querySelector("html");
            html.style.setProperty("--topbar-rgb",  savedTopbarPickr);
        }
 
        // setup theme color all
        const savedSidebarPickr = localStorage.getItem('sidebarRGB') 
        if((savedSidebarTheme == null) && (savedSidebarPickr == null))
        {
            savedSidebarTheme = 'light';
        } else if((savedSidebarPickr != null) && (savedSidebarTheme == null))
        {
           savedSidebarTheme = 'all';
            let html = document.querySelector("html");
            html.style.setProperty("--sidebar-rgb",  savedSidebarPickr);
        }
    
        setThemeAndSidebarTheme(savedTheme, savedSidebarTheme, savedColor, savedLayout, savedTopbar, savedSize, savedWidth);
    
        if (savedSidebarBg) {
            document.body.setAttribute('data-sidebarbg', savedSidebarBg);
        } else {
            document.body.removeAttribute('data-sidebarbg');
        }

        if (savedTopbarBg) {
            document.body.setAttribute('data-topbarbg', savedTopbarBg);
        } else {
            document.body.removeAttribute('data-topbarbg');
        }
    
        // Check and set radio buttons based on saved preferences
        if (document.getElementById(`${savedTheme}Theme`)) {
            document.getElementById(`${savedTheme}Theme`).checked = true;
        }
        if (document.getElementById(`${savedSidebarTheme}Sidebar`)) {
            document.getElementById(`${savedSidebarTheme}Sidebar`).checked = true;
        }
        if (document.getElementById(`${savedColor}Color`)) {
            document.getElementById(`${savedColor}Color`).checked = true;
        }
        if (document.getElementById(`${savedLayout}Layout`)) {
            document.getElementById(`${savedLayout}Layout`).checked = true;
        }
        if (document.getElementById(`${savedTopbar}Topbar`)) {
            document.getElementById(`${savedTopbar}Topbar`).checked = true;
        }
        if (document.getElementById(`${savedSize}Size`)) {
            document.getElementById(`${savedSize}Size`).checked = true;
        }
        if (document.getElementById(`${savedWidth}Width`)) {
            document.getElementById(`${savedWidth}Width`).checked = true;
        }
        if (savedSidebarBg && document.getElementById(`${savedSidebarBg}`)) {
            document.getElementById(`${savedSidebarBg}`).checked = true;
        }
        if (savedTopbarBg && document.getElementById(`${savedTopbarBg}`)) {
            document.getElementById(`${savedTopbarBg}`).checked = true;
        }
    
        // Initially hide sidebar background options based on layout
        if (savedLayout !== 'box' && sidebarBgContainer) {
            sidebarBgContainer.classList.remove('show');
        }
    });
    