<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Form Components Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Bootstrap 5 Form Components Test</h1>
        <p class="text-muted">Testing the migrated form templates from Bootstrap 3 to Bootstrap 5</p>
        
        <form class="row g-3">
            <!-- Text Input Test -->
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name">
                <div class="form-text">This is a Bootstrap 5 text input</div>
            </div>
            
            <!-- Email Input Test -->
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email">
                <div class="form-text">This is a Bootstrap 5 email input</div>
            </div>
            
            <!-- Textarea Test -->
            <div class="col-12">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" rows="3" placeholder="Enter your message"></textarea>
                <div class="form-text">This is a Bootstrap 5 textarea</div>
            </div>
            
            <!-- Select Test -->
            <div class="col-md-6">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category">
                    <option selected disabled>Choose a category...</option>
                    <option value="1">General</option>
                    <option value="2">Support</option>
                    <option value="3">Sales</option>
                </select>
                <div class="form-text">This is a Bootstrap 5 select</div>
            </div>
            
            <!-- Checkbox Test -->
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agree">
                    <label class="form-check-label" for="agree">
                        I agree to the terms and conditions
                    </label>
                </div>
                <div class="form-text">This is a Bootstrap 5 checkbox</div>
            </div>
            
            <!-- Input Group Test -->
            <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text">@</span>
                    <input type="text" class="form-control" id="username" placeholder="Username">
                </div>
                <div class="form-text">This is a Bootstrap 5 input group</div>
            </div>
            
            <!-- Error State Test -->
            <div class="col-md-6">
                <label for="error-field" class="form-label">Field with Error</label>
                <input type="text" class="form-control is-invalid" id="error-field" value="Invalid input">
                <div class="invalid-feedback">
                    This field is required and must be valid.
                </div>
                <div class="form-text">This shows Bootstrap 5 error state</div>
            </div>
            
            <!-- Success State Test -->
            <div class="col-md-6">
                <label for="success-field" class="form-label">Field with Success</label>
                <input type="text" class="form-control is-valid" id="success-field" value="Valid input">
                <div class="valid-feedback">
                    This field looks good!
                </div>
                <div class="form-text">This shows Bootstrap 5 success state</div>
            </div>
            
            <!-- Button Tests -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <button type="button" class="btn btn-secondary me-2">Cancel</button>
                <button type="button" class="btn btn-outline-primary me-2">Outline</button>
                <button type="button" class="btn btn-success me-2">Success</button>
                <button type="button" class="btn btn-danger">Danger</button>
            </div>
        </form>
        
        <hr class="my-5">
        
        <h2>Comparison: Old vs New Classes</h2>
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-danger">Bootstrap 3 (Old)</h4>
                <ul class="list-group">
                    <li class="list-group-item"><code>.control-label</code></li>
                    <li class="list-group-item"><code>.form-control</code> (same)</li>
                    <li class="list-group-item"><code>.has-error</code></li>
                    <li class="list-group-item"><code>.help-block</code></li>
                    <li class="list-group-item"><code>.input-group-addon</code></li>
                    <li class="list-group-item"><code>.checkbox</code></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4 class="text-success">Bootstrap 5 (New)</h4>
                <ul class="list-group">
                    <li class="list-group-item"><code>.form-label</code></li>
                    <li class="list-group-item"><code>.form-control</code> (same)</li>
                    <li class="list-group-item"><code>.is-invalid</code></li>
                    <li class="list-group-item"><code>.form-text</code></li>
                    <li class="list-group-item"><code>.input-group-text</code></li>
                    <li class="list-group-item"><code>.form-check</code></li>
                </ul>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
