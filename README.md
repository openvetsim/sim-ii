# sim-ii
Open VetSim Instructor Interface

sim-ii: Copyright (C) 2019  VetSim, Cornell University College of Veterinary Medicine Ithaca, NY

---

## Release 2.38 Change Notes

Release 2.38 adds Windows compatibility ("noDB mode"), upgrades jQuery and jQuery-UI, integrates OBS WebSocket v5 for recording control, and introduces several UX improvements including temperature unit switching and a hamburger navigation menu.

---

## New Features

### noDB Mode (Windows Compatibility)

The simulator can now run on Windows without a MySQL database, using PHP's built-in web server. When running on Windows (detected via `$_SERVER['OS'] == "Windows"` or the PHP built-in server), the application:

- Loads `adminWin.class.php` and `dbWin.class.php` instead of the MySQL-backed equivalents
- Skips database initialization and login checks
- Routes CGI calls to a local controller on port 40845
- Defines `DIR_SEP` as `"/"` (instead of `DIRECTORY_SEPARATOR`) for cross-platform path compatibility
- Sets `BROWSER_CGI` to the Windows-compatible endpoint

New files supporting noDB mode:
- `adminWin.class.php` — Windows-compatible admin class (no MySQL)
- `dbWin.class.php` — Windows-compatible DB class stub
- `check.php` — Health check endpoint
- `hostCheck.php` — Host/controller detection
- `router.php` — PHP built-in server router

### OBS WebSocket Integration

Instructors can now control OBS (Open Broadcaster Software) recording directly from the simulator interface.

New files:
- `obsControl.html` — OBS control panel UI
- `scripts/obs-websocket-5.js` — OBS WebSocket v5 minified library (replaces v4)
- `scripts/obs-websocket.js` — OBS WebSocket v4 library (retained for compatibility)

### Temperature Unit Switching (Fahrenheit / Celsius)

The Tperi (peripheral temperature) modal now supports runtime switching between Fahrenheit and Celsius:

- New `controls.Tperi.currentUnits` property tracks the active unit
- New `fahrToCent(fahrT)` and `centToFahr(centT)` conversion functions
- New `setModalValues(TperiUnits)` updates the slider min/max/value and display when units change
- Units selection persists via `localStorage` and is synced to the simulator via the `temperature_units` field in the status response
- `ajax/ajaxGetTperiControlContent.php` now includes a Fahrenheit/Celsius dropdown in the modal

### Hamburger Navigation Menu

A collapsible hamburger menu was added to the instructor interface for quick access to hotkeys and secondary controls:

- New `.burger`, `.bar1/.bar2/.bar3`, `.change` CSS classes for animated hamburger icon
- New `.subnav` and `.subnav-content` classes for the dropdown panel
- `burgerTransform()` JavaScript function toggles the menu open/closed
- Permanent hotkey items (`start-comps`, `manual-breath`) repositioned using `.logout.perm-hotkey` CSS

### WinVetSim Version Display

- New `simmgr.wvsVersion` property stores the WinVetSim hardware/firmware version received from the status response (`response.general.wvs_version`)
- Displayed in the About modal

### About Modal

New `modal.aboutModal()` function displays a styled About dialog showing:
- Open VetSim Canine Simulator release version
- Instructor Interface release
- WinVetSim release (from `simmgr.wvsVersion`)
- Detected controller IP address
- Controller firmware version
- Tech support contact and documentation link

Uses new `images/itownlogo.png` branding image.

### TeleSim Interval Tuning

- New `simmgr.isTeleSim()` function checks `localStorage.telesim` flag
- New `simmgr.resetQuickInterval()` sets the polling interval based on mode:
  - TeleSim: 40ms
  - Local display: 15ms
  - Remote user (userID 5): 200ms
  - Default: 40ms
- `getQuickStatus()` pulse tracking now active for both TeleSim and local display modes

---

## Upgrades

### jQuery 2.2.1 → 3.6.4

- `scripts/jquery/3.6.4/jquery.min.js` added
- `header.php` updated to load jQuery 3.6.4
- A `LEGACY` constant flag is set when falling back to jQuery 2.2.1 for older compatibility contexts

### jQuery-UI 1.11.4 → 1.13.2

- Full jQuery-UI 1.13.2 package added to `scripts/jquery-ui/1.13.2/`
- `header.php` updated to load jQuery-UI 1.13.2 JS and CSS

**Slider compatibility fix:** jQuery-UI 1.13.2 requires the slider widget `<div>` and the display `<input>` to be separate elements. Updated in:
- `ajax/ajaxGetSingleControlContent.php` — slider `<div class="control-slider-1">` and `<input class="strip-value new">` separated
- `ajax/ajaxGetTperiControlContent.php` — same separation, plus `display-new` class on input
- `css/modal.css` — updated slider styling for new structure
- `js/controls.js` `heartRate.setHeartRate()` — slider value now explicitly set via `.slider("value", ...)` after modal loads

---

## Modified Files

| File | Change |
|------|--------|
| `init.php` | noDB detection, DIR_SEP constant, conditional CGI/class loading |
| `header.php` | jQuery 3.6.4 + jQuery-UI 1.13.2 upgrade, LEGACY flag, OBS websocket script tag |
| `phpDefinesToJs.php` | Fixed `BROWSER_SCENARIOS` variable name (was `BROWSER_ACTIVE_SCENARIOS`) |
| `admin.class.php` | noDB checks added to all public methods |
| `index.php` | Windows auto-login block, debug output |
| `ii.php` | noDB flag, hamburger menu HTML, `burgerTransform()` JS, `window.name = "WinVetSim II"` |
| `js/controls.js` | Tperi unit switching, slider fix, `wvsVersion` init |
| `js/simmgr.js` | `wvsVersion`, `isTeleSim()`, `resetQuickInterval()`, temperature_units handling in `getStatus()` |
| `js/modal.js` | New `aboutModal()` function |
| `js/events.js` | Whitespace normalization (no functional changes) |
| `ajax/ajaxGetSingleControlContent.php` | Slider/input separation for jQuery-UI 1.13.2 |
| `ajax/ajaxGetTperiControlContent.php` | Slider/input separation + Tperi units dropdown |
| `css/common.css` | Hamburger menu CSS |
| `css/modal.css` | Slider styling for jQuery-UI 1.13.2 |

## New Files

| File | Description |
|------|-------------|
| `adminWin.class.php` | Windows/noDB admin class |
| `dbWin.class.php` | Windows/noDB database class stub |
| `check.php` | Health check endpoint |
| `hostCheck.php` | Host/controller detection endpoint |
| `router.php` | PHP built-in server router |
| `obsControl.html` | OBS recording control panel |
| `scripts/obs-websocket-5.js` | OBS WebSocket v5 minified library |
| `scripts/jquery/3.6.4/jquery.min.js` | jQuery 3.6.4 |
| `scripts/jquery-ui/1.13.2/` | jQuery-UI 1.13.2 full package |
| `images/itownlogo.png` | iTown Design logo for About modal |
