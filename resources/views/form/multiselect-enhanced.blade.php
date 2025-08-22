{{-- Enhanced multi-select with search and tags --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($errorKey) ? '' : 'has-validation' !!}">
    <label for="{{$id}}" class="{{$viewClass['label']}} form-label">{{$label}}</label>
    
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        
        <div class="multi-select-container" id="multiselect-{{$id}}">
            <!-- Hidden input for form submission -->
            <input type="hidden" name="{{$name}}" id="{{$id}}-hidden">
            
            <!-- Multi-select wrapper -->
            <div class="multi-select-wrapper">
                <div class="multi-select-input-container">
                    <!-- Selected tags -->
                    <div class="selected-tags" id="{{$id}}-tags"></div>
                    
                    <!-- Search input -->
                    <input type="text" 
                           class="multi-select-input form-control" 
                           id="{{$id}}-search"
                           placeholder="{{ count($selected ?? []) > 0 ? 'Add more...' : 'Search and select options...' }}"
                           autocomplete="off">
                </div>
                
                <!-- Dropdown toggle button -->
                <button type="button" class="multi-select-toggle">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            
            <!-- Options dropdown -->
            <div class="multi-select-dropdown" id="{{$id}}-dropdown">
                <div class="dropdown-header">
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <span class="search-placeholder">Type to search...</span>
                    </div>
                    
                    @if($allowSelectAll ?? true)
                        <div class="select-all-container">
                            <button type="button" class="btn btn-sm btn-outline-primary select-all-btn">
                                Select All
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary clear-all-btn">
                                Clear All
                            </button>
                        </div>
                    @endif
                </div>
                
                <div class="options-container" id="{{$id}}-options">
                    @if($groups ?? false)
                        @foreach($groups as $group)
                            <div class="option-group">
                                <div class="group-label">{{ $group['label'] }}</div>
                                @foreach($group['options'] as $value => $label)
                                    <div class="option-item" data-value="{{ $value }}">
                                        <div class="option-checkbox">
                                            <i class="far fa-square unchecked"></i>
                                            <i class="fas fa-check-square checked"></i>
                                        </div>
                                        <span class="option-label">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        @foreach($options as $value => $label)
                            <div class="option-item" data-value="{{ $value }}">
                                <div class="option-checkbox">
                                    <i class="far fa-square unchecked"></i>
                                    <i class="fas fa-check-square checked"></i>
                                </div>
                                <span class="option-label">{{ $label }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <div class="no-options-message d-none">
                    <i class="fas fa-search"></i>
                    <span>No options found</span>
                </div>
            </div>
        </div>

        @include('admin::form.help-block')
    </div>
</div>

<style>
/* Enhanced multi-select styles */
.multi-select-container {
    position: relative;
    width: 100%;
}

.multi-select-wrapper {
    display: flex;
    align-items: stretch;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    background-color: #fff;
    transition: all 0.3s ease;
    min-height: 38px;
}

.multi-select-wrapper:hover {
    border-color: #86b7fe;
}

.multi-select-wrapper.focused {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.multi-select-input-container {
    flex: 1;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    min-height: 36px;
}

.selected-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
}

.selected-tag {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: white;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    animation: tagAppear 0.3s ease-out;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

@keyframes tagAppear {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.tag-remove {
    margin-left: 0.5rem;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s ease;
    font-size: 0.75rem;
}

.tag-remove:hover {
    opacity: 1;
}

.multi-select-input {
    border: none;
    outline: none;
    background: none;
    flex: 1;
    min-width: 150px;
    padding: 0.25rem;
    font-size: 0.875rem;
}

.multi-select-input::placeholder {
    color: #6c757d;
    font-style: italic;
}

.multi-select-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    padding: 0.5rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.2s ease;
    border-left: 1px solid #ced4da;
}

.multi-select-toggle:hover {
    background-color: #f8f9fa;
    color: #0d6efd;
}

.multi-select-toggle i {
    transition: transform 0.3s ease;
}

.multi-select-container.open .multi-select-toggle i {
    transform: rotate(180deg);
}

/* Dropdown styles */
.multi-select-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ced4da;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    max-height: 300px;
    display: none;
    overflow: hidden;
}

.multi-select-container.open .multi-select-dropdown {
    display: block;
    animation: dropdownSlide 0.3s ease-out;
}

@keyframes dropdownSlide {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-header {
    padding: 0.75rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ced4da;
}

.search-container {
    display: flex;
    align-items: center;
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.search-container i {
    margin-right: 0.5rem;
}

.select-all-container {
    display: flex;
    gap: 0.5rem;
}

.select-all-container .btn {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.options-container {
    max-height: 200px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #ced4da transparent;
}

.options-container::-webkit-scrollbar {
    width: 6px;
}

.options-container::-webkit-scrollbar-track {
    background: transparent;
}

.options-container::-webkit-scrollbar-thumb {
    background: #ced4da;
    border-radius: 3px;
}

.option-group {
    border-bottom: 1px solid #e9ecef;
}

.group-label {
    padding: 0.5rem 0.75rem;
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.option-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.option-item:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
}

.option-item.selected {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
    font-weight: 500;
}

.option-checkbox {
    margin-right: 0.75rem;
    font-size: 1rem;
    color: #ced4da;
    transition: color 0.2s ease;
}

.option-item.selected .option-checkbox {
    color: #0d6efd;
}

.option-checkbox .checked {
    display: none;
}

.option-item.selected .option-checkbox .unchecked {
    display: none;
}

.option-item.selected .option-checkbox .checked {
    display: inline;
}

.option-label {
    flex: 1;
    font-size: 0.875rem;
}

.option-item.hidden {
    display: none;
}

.no-options-message {
    padding: 2rem;
    text-align: center;
    color: #6c757d;
    font-style: italic;
}

.no-options-message i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .multi-select-wrapper {
        background-color: #343a40;
        border-color: #495057;
        color: #ffffff;
    }
    
    .multi-select-dropdown {
        background-color: #343a40;
        border-color: #495057;
    }
    
    .dropdown-header {
        background-color: #495057;
        border-bottom-color: #6c757d;
    }
    
    .option-item:hover {
        background-color: #495057;
    }
    
    .group-label {
        background-color: #495057;
        color: #ffffff;
        border-bottom-color: #6c757d;
    }
}

/* Responsive design */
@media (max-width: 576px) {
    .multi-select-input {
        min-width: 100px;
    }
    
    .selected-tag {
        font-size: 0.75rem;
        padding: 0.125rem 0.25rem;
    }
    
    .select-all-container {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const multiSelects = document.querySelectorAll('.multi-select-container');
    
    multiSelects.forEach(container => {
        const id = container.id.replace('multiselect-', '');
        const wrapper = container.querySelector('.multi-select-wrapper');
        const searchInput = container.querySelector(`#${id}-search`);
        const hiddenInput = container.querySelector(`#${id}-hidden`);
        const dropdown = container.querySelector(`#${id}-dropdown`);
        const tagsContainer = container.querySelector(`#${id}-tags`);
        const optionsContainer = container.querySelector(`#${id}-options`);
        const toggleBtn = container.querySelector('.multi-select-toggle');
        const selectAllBtn = container.querySelector('.select-all-btn');
        const clearAllBtn = container.querySelector('.clear-all-btn');
        const noOptionsMessage = container.querySelector('.no-options-message');
        
        let selectedValues = [];
        let allOptions = [];
        
        // Initialize options
        const optionItems = container.querySelectorAll('.option-item');
        optionItems.forEach(item => {
            allOptions.push({
                value: item.dataset.value,
                label: item.querySelector('.option-label').textContent.trim(),
                element: item
            });
        });
        
        // Set initial selected values
        const initialSelected = @json($selected ?? []);
        if (Array.isArray(initialSelected)) {
            selectedValues = initialSelected;
            updateDisplay();
        }
        
        // Toggle dropdown
        function toggleDropdown() {
            container.classList.toggle('open');
            if (container.classList.contains('open')) {
                searchInput.focus();
                wrapper.classList.add('focused');
            } else {
                wrapper.classList.remove('focused');
            }
        }
        
        // Event listeners
        toggleBtn.addEventListener('click', toggleDropdown);
        
        searchInput.addEventListener('focus', () => {
            container.classList.add('open');
            wrapper.classList.add('focused');
        });
        
        searchInput.addEventListener('blur', (e) => {
            // Delay to allow clicking on dropdown items
            setTimeout(() => {
                if (!container.contains(document.activeElement)) {
                    container.classList.remove('open');
                    wrapper.classList.remove('focused');
                }
            }, 200);
        });
        
        // Search functionality
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            let visibleCount = 0;
            
            allOptions.forEach(option => {
                const matches = option.label.toLowerCase().includes(query);
                option.element.classList.toggle('hidden', !matches);
                if (matches) visibleCount++;
            });
            
            noOptionsMessage.classList.toggle('d-none', visibleCount > 0);
        });
        
        // Option selection
        optionItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                const value = item.dataset.value;
                const label = item.querySelector('.option-label').textContent.trim();
                
                if (selectedValues.includes(value)) {
                    selectedValues = selectedValues.filter(v => v !== value);
                } else {
                    selectedValues.push(value);
                }
                
                updateDisplay();
                searchInput.focus();
            });
        });
        
        // Select all
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', () => {
                selectedValues = allOptions.map(option => option.value);
                updateDisplay();
            });
        }
        
        // Clear all
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', () => {
                selectedValues = [];
                updateDisplay();
            });
        }
        
        // Update display
        function updateDisplay() {
            // Update hidden input
            hiddenInput.value = JSON.stringify(selectedValues);
            
            // Update tags
            tagsContainer.innerHTML = '';
            selectedValues.forEach(value => {
                const option = allOptions.find(opt => opt.value === value);
                if (option) {
                    const tag = createTag(option.label, value);
                    tagsContainer.appendChild(tag);
                }
            });
            
            // Update option items
            optionItems.forEach(item => {
                const isSelected = selectedValues.includes(item.dataset.value);
                item.classList.toggle('selected', isSelected);
            });
            
            // Update placeholder
            searchInput.placeholder = selectedValues.length > 0 ? 'Add more...' : 'Search and select options...';
            
            // Clear search
            searchInput.value = '';
            
            // Show all options
            allOptions.forEach(option => {
                option.element.classList.remove('hidden');
            });
            noOptionsMessage.classList.add('d-none');
        }
        
        // Create tag element
        function createTag(label, value) {
            const tag = document.createElement('span');
            tag.className = 'selected-tag';
            tag.innerHTML = `
                ${label}
                <i class="fas fa-times tag-remove" data-value="${value}"></i>
            `;
            
            // Remove tag event
            tag.querySelector('.tag-remove').addEventListener('click', (e) => {
                e.stopPropagation();
                selectedValues = selectedValues.filter(v => v !== value);
                updateDisplay();
            });
            
            return tag;
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) {
                container.classList.remove('open');
                wrapper.classList.remove('focused');
            }
        });
        
        // Keyboard navigation
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                container.classList.remove('open');
                wrapper.classList.remove('focused');
            }
        });
    });
});
</script>
