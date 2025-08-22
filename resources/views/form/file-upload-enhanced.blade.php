{{-- Enhanced drag-and-drop file upload field --}}
<div class="{{$viewClass['form-group']}} mb-3 {!! !$errors->has($errorKey) ? '' : 'has-validation' !!}">
    <label for="{{$id}}" class="{{$viewClass['label']}} form-label">{{$label}}</label>
    
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        
        <div class="file-upload-container">
            <!-- Hidden file input -->
            <input type="file" 
                   id="{{$id}}" 
                   name="{{$name}}"
                   class="file-input d-none" 
                   {!! $attributes !!}
                   {{ $multiple ? 'multiple' : '' }}
                   accept="{{ $accept ?? '' }}">
            
            <!-- Drag and drop zone -->
            <div class="file-drop-zone" id="dropzone-{{$id}}">
                <div class="drop-zone-content text-center py-5">
                    <div class="drop-zone-icon mb-3">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                    </div>
                    <h4 class="drop-zone-title">Drag & Drop Files Here</h4>
                    <p class="drop-zone-subtitle text-muted mb-3">
                        Or <button type="button" class="btn btn-link p-0 browse-btn">browse files</button> to upload
                    </p>
                    
                    @if($accept)
                        <small class="text-muted">Accepted formats: {{ $accept }}</small>
                    @endif
                    
                    @if($maxSize)
                        <small class="text-muted d-block">Maximum file size: {{ $maxSize }}MB</small>
                    @endif
                </div>
                
                <!-- File preview area -->
                <div class="file-preview-container mt-3 d-none">
                    <h6 class="mb-2">Selected Files:</h6>
                    <div class="file-preview-list"></div>
                </div>
                
                <!-- Progress bar -->
                <div class="upload-progress mt-3 d-none">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" 
                             style="width: 0%">
                            <span class="progress-text">0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin::form.help-block')
    </div>
</div>

<style>
/* Enhanced file upload styles */
.file-upload-container {
    position: relative;
}

.file-drop-zone {
    border: 2px dashed #dee2e6;
    border-radius: 0.5rem;
    background-color: #f8f9fa;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.file-drop-zone:hover,
.file-drop-zone.drag-over {
    border-color: var(--bs-primary);
    background-color: rgba(var(--bs-primary-rgb), 0.05);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.file-drop-zone.drag-over::after {
    content: 'Release to upload files';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(var(--bs-primary-rgb), 0.9);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 600;
    z-index: 10;
}

.drop-zone-icon {
    transition: transform 0.3s ease-in-out;
}

.file-drop-zone:hover .drop-zone-icon {
    transform: scale(1.1);
}

.browse-btn {
    color: var(--bs-primary) !important;
    text-decoration: none;
    font-weight: 600;
    border-bottom: 2px solid transparent;
    transition: border-color 0.2s ease;
}

.browse-btn:hover {
    border-bottom-color: var(--bs-primary);
}

/* File preview styles */
.file-preview-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
    background: white;
    transition: all 0.2s ease;
}

.file-preview-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.file-preview-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bs-primary);
    color: white;
    border-radius: 0.25rem;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.file-preview-info {
    flex: 1;
}

.file-preview-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #333;
}

.file-preview-size {
    font-size: 0.875rem;
    color: #6c757d;
}

.file-remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 50%;
    transition: background-color 0.2s ease;
}

.file-remove-btn:hover {
    background-color: rgba(220, 53, 69, 0.1);
}

/* Progress bar enhancements */
.upload-progress .progress {
    height: 20px;
    background-color: #e9ecef;
}

.upload-progress .progress-bar {
    background: linear-gradient(45deg, 
                               var(--bs-primary), 
                               rgba(var(--bs-primary-rgb), 0.8));
    position: relative;
    transition: width 0.3s ease;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

/* Animation for file upload */
@keyframes fileUpload {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.file-preview-item {
    animation: fileUpload 0.3s ease-out;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .file-drop-zone {
        background-color: #212529;
        border-color: #495057;
    }
    
    .file-drop-zone:hover,
    .file-drop-zone.drag-over {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
    }
    
    .file-preview-item {
        background: #343a40;
        border-color: #495057;
    }
    
    .file-preview-name {
        color: #ffffff;
    }
}

/* Responsive design */
@media (max-width: 576px) {
    .drop-zone-content {
        padding: 2rem 1rem !important;
    }
    
    .drop-zone-icon i {
        font-size: 2rem !important;
    }
    
    .drop-zone-title {
        font-size: 1.1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzones = document.querySelectorAll('.file-drop-zone');
    
    dropzones.forEach(dropzone => {
        const fileInput = dropzone.closest('.file-upload-container').querySelector('.file-input');
        const browseBtn = dropzone.querySelector('.browse-btn');
        const previewContainer = dropzone.querySelector('.file-preview-container');
        const previewList = dropzone.querySelector('.file-preview-list');
        const progressContainer = dropzone.querySelector('.upload-progress');
        const progressBar = progressContainer.querySelector('.progress-bar');
        const progressText = progressContainer.querySelector('.progress-text');
        
        let selectedFiles = [];
        
        // Browse button click
        browseBtn.addEventListener('click', () => {
            fileInput.click();
        });
        
        // File input change
        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });
        
        // Drag and drop events
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('drag-over');
        });
        
        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            if (!dropzone.contains(e.relatedTarget)) {
                dropzone.classList.remove('drag-over');
            }
        });
        
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('drag-over');
            handleFiles(e.dataTransfer.files);
        });
        
        // Handle selected files
        function handleFiles(files) {
            selectedFiles = Array.from(files);
            displayFilePreview();
            simulateUploadProgress();
        }
        
        // Display file preview
        function displayFilePreview() {
            if (selectedFiles.length === 0) {
                previewContainer.classList.add('d-none');
                return;
            }
            
            previewContainer.classList.remove('d-none');
            previewList.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                const previewItem = createFilePreviewItem(file, index);
                previewList.appendChild(previewItem);
            });
        }
        
        // Create file preview item
        function createFilePreviewItem(file, index) {
            const item = document.createElement('div');
            item.className = 'file-preview-item';
            
            const icon = getFileIcon(file.type);
            const size = formatFileSize(file.size);
            
            item.innerHTML = `
                <div class="file-preview-icon">
                    <i class="fas ${icon}"></i>
                </div>
                <div class="file-preview-info">
                    <div class="file-preview-name">${file.name}</div>
                    <div class="file-preview-size">${size}</div>
                </div>
                <button type="button" class="file-remove-btn" onclick="removeFile(${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            return item;
        }
        
        // Get file icon based on type
        function getFileIcon(type) {
            if (type.startsWith('image/')) return 'fa-image';
            if (type.startsWith('video/')) return 'fa-video';
            if (type.startsWith('audio/')) return 'fa-music';
            if (type.includes('pdf')) return 'fa-file-pdf';
            if (type.includes('word')) return 'fa-file-word';
            if (type.includes('excel') || type.includes('spreadsheet')) return 'fa-file-excel';
            if (type.includes('powerpoint') || type.includes('presentation')) return 'fa-file-powerpoint';
            if (type.includes('zip') || type.includes('rar')) return 'fa-file-archive';
            return 'fa-file';
        }
        
        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Simulate upload progress
        function simulateUploadProgress() {
            if (selectedFiles.length === 0) return;
            
            progressContainer.classList.remove('d-none');
            let progress = 0;
            
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    setTimeout(() => {
                        progressContainer.classList.add('d-none');
                        showSuccessMessage();
                    }, 1000);
                }
                
                progressBar.style.width = progress + '%';
                progressText.textContent = Math.round(progress) + '%';
            }, 200);
        }
        
        // Show success message
        function showSuccessMessage() {
            const successAlert = document.createElement('div');
            successAlert.className = 'alert alert-success alert-dismissible fade show mt-3';
            successAlert.innerHTML = `
                <i class="fas fa-check-circle"></i>
                Files uploaded successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            dropzone.appendChild(successAlert);
            
            setTimeout(() => {
                successAlert.remove();
            }, 5000);
        }
        
        // Remove file function (global scope)
        window.removeFile = function(index) {
            selectedFiles.splice(index, 1);
            displayFilePreview();
            
            // Update file input
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        };
    });
});
</script>
