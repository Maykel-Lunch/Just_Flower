@if(Auth::id() !== 1) 
    <script>
        window.location.href = "{{ route('dashboard') }}";
    </script>
@else
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Delivery Confirmation</h1>
            
            @if (session('success'))
                <div class="mb-6 bg-green-100 text-green-800 px-4 py-2 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-100 text-red-800 px-4 py-2 rounded-md">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="deliveryForm" method="POST" action="{{ route('admin.uploadConfirmationPhoto') }}" enctype="multipart/form-data">
                @csrf
                <!-- Order ID Dropdown -->
                <div class="mb-6">
                    <label for="orderId" class="block text-sm font-medium text-gray-700 mb-2">Order ID</label>
                    <select id="orderId" name="orderId" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="" disabled selected>Select an Order ID</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->order_id }}">{{ $order->order_id }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Photo Section -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Proof</label>
                    
                    <!-- Preview Area -->
                    <div class="mb-4 border-2 border-dashed border-gray-300 rounded-md p-4 text-center">
                        <img id="photoPreview" src="" alt="Preview will appear here" 
                             class="mx-auto max-h-64 hidden mb-2 rounded-md">
                        <p id="noPhotoText" class="text-gray-500">No photo selected</p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <!-- Upload Button -->
                        <button type="button" id="uploadBtn" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload Photo
                        </button>
                        
                        <!-- Camera Button -->
                        <button type="button" id="cameraBtn" 
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md flex items-center justify-center sm:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0" />
                            </svg>
                            Take Photo
                        </button>
                    </div>
                    
                    <!-- Hidden file input -->
                    <input type="file" id="confirmation_photo" name="confirmation_photo" accept="image/*" class="hidden" required>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" id="submitBtn"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Confirm Delivery
                </button>
            </form>
        </div>
    </div>

    
</body>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadBtn = document.getElementById('uploadBtn');
        const cameraBtn = document.getElementById('cameraBtn');
        const fileInput = document.getElementById('confirmation_photo');
        const photoPreview = document.getElementById('photoPreview');
        const noPhotoText = document.getElementById('noPhotoText');
        const form = document.getElementById('deliveryForm');
        const submitBtn = document.getElementById('submitBtn');
        
        // Check if camera is supported
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            cameraBtn.classList.remove('sm:hidden');
        }
        
        // Handle upload button click
        uploadBtn.addEventListener('click', function() {
            fileInput.removeAttribute('capture');
            fileInput.click();
        });
        
        // Handle camera button click
        cameraBtn.addEventListener('click', function() {
            fileInput.setAttribute('capture', 'environment');
            fileInput.click();
        });
        
        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    photoPreview.src = event.target.result;
                    photoPreview.classList.remove('hidden');
                    noPhotoText.classList.add('hidden');
                }
                
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Uploading...
            `;
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'mb-6 bg-green-100 text-green-800 px-4 py-2 rounded-md';
                    successDiv.textContent = data.message;
                    form.prepend(successDiv);
                    
                    // Reset form and preview
                    form.reset();
                    photoPreview.src = '';
                    photoPreview.classList.add('hidden');
                    noPhotoText.classList.remove('hidden');
                    
                    // Optionally redirect or refresh after 2 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the photo');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Confirm Delivery';
            });
        });
    });
</script>
@endif