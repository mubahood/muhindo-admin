# Bootstrap 5 Class Migration Mapping

## Priority 2.2: Component Migration Plan
**Status**: 🚧 IN PROGRESS  
**Created**: August 3, 2025

## Bootstrap 3 → Bootstrap 5 Class Mappings

### Form Classes
```
Bootstrap 3              → Bootstrap 5
=============================================
control-label           → form-label
form-control            → form-control (unchanged)
has-error               → is-invalid
has-success             → is-valid
help-block              → form-text
form-group              → mb-3 (margin-bottom-3)
input-group-addon       → input-group-text
```

### Grid System  
```
Bootstrap 3              → Bootstrap 5
=============================================
col-xs-*                → col-* 
col-sm-*                → col-sm-*
col-md-*                → col-md-*
col-lg-*                → col-lg-*
col-*-offset-*          → offset-*-*
pull-left               → float-start
pull-right              → float-end
text-left               → text-start
text-right              → text-end
```

### Button Classes
```
Bootstrap 3              → Bootstrap 5
=============================================
btn-default             → btn-secondary
btn-xs                  → btn-sm (extra small removed)
```

### Panel/Card Classes
```
Bootstrap 3              → Bootstrap 5
=============================================
panel                   → card
panel-heading           → card-header
panel-body              → card-body
panel-footer            → card-footer
panel-default           → (removed, use card)
panel-primary           → card with border-primary
```

### Utility Classes
```
Bootstrap 3              → Bootstrap 5
=============================================
hidden-*                → d-*-none
visible-*               → d-*-block/inline/etc
center-block            → mx-auto
img-responsive          → img-fluid
thumbnail               → (removed, use card or custom)
```

## Files Requiring Bootstrap 5 Updates

### Core Templates
- [ ] `index.blade.php` - Main layout structure
- [ ] `content.blade.php` - Content wrapper 
- [ ] `partials/header.blade.php` - Navigation header
- [ ] `partials/sidebar.blade.php` - Sidebar navigation

### Form Field Templates (High Priority)
- [ ] `form/textarea.blade.php` - ✅ Identified: `control-label`, `form-control`, `has-error`
- [ ] `form/text.blade.php` - Text input fields
- [ ] `form/select.blade.php` - Select dropdowns
- [ ] `form/checkbox.blade.php` - Checkbox inputs
- [ ] `form/radio.blade.php` - Radio button inputs
- [ ] `form/help-block.blade.php` - Help text component
- [ ] `form/tab.blade.php` - Tab navigation

### Grid/Layout Templates
- [ ] `show/panel.blade.php` - Detail view panels
- [ ] `show/field.blade.php` - Field display components
- [ ] `grid/` templates - Data table components

### Widget/Component Templates  
- [ ] `tree/branch.blade.php` - Tree view components
- [ ] `form/hasmany.blade.php` - Relationship forms
- [ ] `form/keyvalue.blade.php` - Key-value pair inputs

## Implementation Strategy

### Phase 1: Form Field Migration (Current)
1. **Target**: Core form field templates with Bootstrap 3 classes
2. **Approach**: Systematic class replacement using Bootstrap 5 equivalents
3. **Testing**: Validate each form field renders correctly

### Phase 2: Layout Structure Migration  
1. **Target**: Main layout templates, panels, cards
2. **Approach**: Convert panel/card structures to Bootstrap 5
3. **Testing**: Ensure responsive design maintained

### Phase 3: Grid/Table Migration
1. **Target**: Data grid templates and table layouts  
2. **Approach**: Update grid classes and table structures
3. **Testing**: Verify data display and interactions

### Phase 4: Navigation/UI Migration
1. **Target**: Header, sidebar, navigation components
2. **Approach**: Modernize navigation structure 
3. **Testing**: Ensure all navigation functionality works

## Migration Validation Checklist

### Functionality Testing
- [ ] Form field rendering and validation
- [ ] Grid sorting and filtering  
- [ ] Navigation and routing
- [ ] Responsive design across devices
- [ ] JavaScript component integration

### Visual Testing  
- [ ] Form styling consistency
- [ ] Button and input appearances
- [ ] Panel/card layouts
- [ ] Color schemes and themes
- [ ] AdminLTE 4.0 integration readiness

## Notes
- Bootstrap 5 removes jQuery dependency (affects existing JS)
- AdminLTE 4.0 will provide Bootstrap 5 compatible components
- Some Bootstrap 3 classes have no direct equivalent and need custom CSS
- Form validation styling significantly changed in Bootstrap 5

## Next Actions
1. Start with `form/textarea.blade.php` template migration  
2. Create reusable partial for form groups
3. Test form field rendering with Bootstrap 5 classes
4. Document any custom CSS needed for visual consistency
