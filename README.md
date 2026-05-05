# sim-ii
Open VetSim Instructor Interface

sim-ii: Copyright (C) 2019-2026  VetSim, Cornell University College of Veterinary Medicine Ithaca, NY

---

## Release 2.42 Change Notes

Release 2.42 is a targeted bug fix plus version bump.

### Bug Fix: Empty Hotkey Strings (`ajax/ajaxGetEventsList.php`)

Events with a `hotkey` field set to an empty string (`""`) were incorrectly triggering the duplicate hotkey detection added in 2.39. A guard is now applied before the `checkHotkey()` call: if `$event['hotkey']` exists but has zero length, it is `unset()` so it is treated as having no hotkey at all.

### Version Bump (`js/modal.js`)

- `Release 2.41` → `Release 2.42`
- `Instructor Interface Release 2.41-WVS` → `Instructor Interface Release 2.42-WVS`

---

## Release 2.41 Change Notes

Release 2.41 adds dynamic controller firmware version fetching via a new Windows executable and AJAX endpoint, and bumps version strings throughout.

### Dynamic Controller Firmware Version

Previously the firmware version was hardcoded in the About modal. It is now fetched live from the connected controller:

- **New `fetchversion.exe`** — Windows PE32+ executable (211KB) placed in the sim-ii root. Queries a controller by IP address and returns its firmware version string.
- **New `ajax/ajaxGetCntrlStat.php`** — AJAX endpoint that calls `fetchversion.exe <ip>` via PHP `exec()` and returns `{ ver: "..." }`. Falls back gracefully with `"no data"` or `"failed"` on error.
- **`js/controls.js`** — New `fwVers: ""` property added to the `controllers` object to store the fetched version.
- **`js/simmgr.js`** — When a controller IP is detected, an AJAX call is made to `ajaxGetCntrlStat.php`. On success, `controls.controllers.fwVers` is populated; on failure it is set to `"Controller not found"`.
- **`js/modal.js`** — `aboutModal()` now displays `Controller Firmware Version: ' + controls.controllers.fwVers` dynamically instead of the hardcoded `1.1.10`.

### Version Bumps

- **`init.php`**: `VERSION_MINOR` `2.3-WVS` → `41-WVS`
- **`js/modal.js`**: `Release 2.40` → `Release 2.41`; `Instructor Interface Release 2.4-WVS` → `Instructor Interface Release 2.41-WVS`

### New Files

| File | Description |
|------|-------------|
| `fetchversion.exe` | Windows executable to query controller firmware version by IP |
| `ajax/ajaxGetCntrlStat.php` | AJAX endpoint wrapping `fetchversion.exe` |

---

## Release 2.40 Change Notes

Release 2.40 is a version bump release with no functional code changes beyond updated version identifiers.

### Version Bumps (`js/modal.js`)

- `Release 2.39` → `Release 2.40`
- `Instructor Interface Release 2.3-WVS` → `Instructor Interface Release 2.4-WVS`
- `Controller Firmware Version: 1.1.8` → `Controller Firmware Version: 1.1.10`

---

## Release 2.39 Change Notes

Release 2.39 completes the jQuery-UI 1.13.2 slider refactoring across all remaining modals, gates unavailable sound options in the UI, adds CPR keyboard shortcuts, improves error diagnostics throughout the AJAX layer, removes the scenario file upload UI in favor of folder-based installation, and fixes a truncated `phpDefinesToJs.php`.

### Slider Refactoring — All Remaining Modals

Completed the jQuery-UI 1.13.2 slider compatibility fix (started in 2.38) for all modals that were not yet updated. The combined `<input>` slider element is split into a separate `<div class="control-slider-1">` widget and `<input class="strip-value new">` display field in:
- `ajax/ajaxGetHeartRhythmContent.php`
- `ajax/ajaxGetHeartSoundContent.php` (volume slider)
- `ajax/ajaxGetLungSoundContent.php` (volume slider)
- `ajax/ajaxGetNBPControlContent.php` — all three controls (systolic, diastolic, linked-hr); new `nibp` CSS class added to slider divs
- `ajax/ajaxGetPulseStrengthControlContent.php` (sensitivity slider)
- `ajax/ajaxGetVocalsControlContent.php` (volume slider)

### Sound Option Gating

Only supported sounds are now enabled in the UI; unsupported options are rendered with the `disabled` attribute:

- **Heart sounds** (`ajaxGetHeartSoundContent.php`): Only `normal` and `systolic_murmur` are enabled; all other options are disabled.
- **Lung sounds** (`ajaxGetLungSoundContent.php`): `Stridor` and `Stertor` are disabled; all other lung sounds remain enabled.

### CPR Keyboard Shortcuts

`scripts/hotkeys.js` adds two new keyboard shortcuts for CPR control:
- `<` — starts CPR (clicks the CPR link when the button shows "Start")
- `>` — stops CPR (clicks the CPR link when the button does not show "Start")

### Touch Sensitivity Section Hidden

The touch sensitivity section in the pulse strength modal (`ajaxGetPulseStrengthControlContent.php`) is now hidden via `style="display: none;"` on both the divider and the control div.

### Hotkey Duplication Detection

`ajax/ajaxGetEventsList.php` now detects and reports duplicate hotkey definitions:
- Returns `hotLinkDup: 'true'` in the AJAX response when a duplicate predefined hotkey (`b` or `c`) is encountered
- `js/events.js` displays an alert: *"Predefined hotkeys (b) or (c) cannot be redefined. Hotkey definition has been ignored"*
- Hotkey array now includes `title` field alongside `hotkey` and `id`
- Validation improved: four separate checks with `reason` codes (`"missing arg"`, `"no array returned"`, `"eventsArray is Type..."`, `"eventsArray count is ..."`)
- `console.log("hotkey:", key.hotkey, key.id)` added for debugging

### Improved AJAX Error Diagnostics

Additional fields added to failure response payloads:
- `ajaxGetEventsLog.php`: `fileName`, `logRecordCount`, `arrayCount` exposed in failure responses
- `ajaxGetScenario.php`: `cause` field added to five failure blocks (`"scenarioProfileArray failed"`, `"scenarioHeaderArray failed"`, `"getScenarioEventsArray failed"`, `"getScenarioMediaArray failed"`, `"getScenarioVocalsArray failed"`)
- `ajaxGetEventsList.php`: `reason` field added to all validation failure responses

### Scenario Upload UI Removed

`ajax/ajaxGetScenarioTableContent.php`: The file upload form for adding scenarios is replaced with an instruction message:
> *"Please add scenarios by unzipping *.zip scenario files into the scenario folder. The scenario folder can be found using the icon on your desktop."*

The old upload form is preserved as commented-out HTML.

### phpDefinesToJs.php Fix

- Adds `var ETCO2_OK = 0;` constant (new in 2.39)
- Restores missing closing `</script>` tag — the Dev file was truncated and missing its final two lines

### Version Bump

- `js/modal.js` `aboutModal()` function updated: `Release 2.38` → `Release 2.39`

### New Assets

| File | Description |
|------|-------------|
| `images/K9logo.png` | Canine logo image |
| `scripts/jquery/3.6.0/jquery.min.js` | jQuery 3.6.0 (retained alongside 3.6.4) |
| `scripts/jquery-ui/1.13.2/AUTHORS.txt` | jQuery-UI attribution |
| `scripts/jquery-ui/1.13.2/LICENSE.txt` | jQuery-UI license |
| `scripts/jquery-ui/1.13.2/index.html` | jQuery-UI package index |
| `scripts/jquery-ui/1.13.2/package.json` | jQuery-UI package manifest |
| `scripts/jquery-ui/1.13.2/jquery-ui.structure.css` | jQuery-UI structure stylesheet |
| `scripts/jquery-ui/1.13.2/jquery-ui.theme.css` | jQuery-UI theme stylesheet |
| `scripts/jquery-ui/1.13.2/images/` | jQuery-UI icon images (11 files) |

### Modified Files (2.39)

| File | Change |
|------|--------|
| `ajax/ajaxGetEventsList.php` | Hotkey dup detection, validation reason codes, title in hotkey array |
| `ajax/ajaxGetEventsLog.php` | Diagnostic fields in failure responses |
| `ajax/ajaxGetHeartRhythmContent.php` | Slider div/input separation |
| `ajax/ajaxGetHeartSoundContent.php` | Sound option gating + slider separation |
| `ajax/ajaxGetLungSoundContent.php` | Sound option gating + slider separation |
| `ajax/ajaxGetNBPControlContent.php` | Slider separation, new `nibp` CSS class |
| `ajax/ajaxGetPulseStrengthControlContent.php` | Sensitivity section hidden, slider separation |
| `ajax/ajaxGetScenario.php` | Cause field in failure responses |
| `ajax/ajaxGetScenarioTableContent.php` | Upload form replaced with instructions |
| `ajax/ajaxGetVocalsControlContent.php` | Slider div/input separation |
| `includes/phpDefinesToJs.php` | Adds ETCO2_OK, restores closing tag |
| `js/events.js` | Hotkey dup alert, console.log for hotkeys |
| `js/modal.js` | Version bump 2.38 → 2.39 (+37 lines) |
| `js/simmgr.js` | +15 lines (functional changes) |
| `js/controls.js` | Functional updates |
| `scripts/hotkeys.js` | New `<`/`>` CPR keyboard shortcuts |
| `ii.php` | +46 lines (UI/functional updates) |

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
