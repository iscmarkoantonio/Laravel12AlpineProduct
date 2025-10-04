@extends('layouts.app')

@section('content')
    <div x-data="productManager()" x-init="init()" class="py-4">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Products list</h1>

            {{-- Button to create product --}}
            <button @click="openModal('create')"
                class="flex items-center cursor-pointer bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                <i data-lucide="plus-circle" class="h-4 w-4 mr-1"></i>
                Add Product</button>
        </div>
        {{-- Table --}}
        <div class="bg-white shadow-md rounded overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left border-b border-gray-400">
                        <th class="px-4 py-2 font-semibold">#</th>
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Sku</th>
                        <th class="px-4 py-2 font-semibold flex items-center">Price <i data-lucide="dollar-sign"
                                class="w-4 h-4 ml-1"></th>
                        <th class="px-4 py-2 font-semibold">Status</th>
                        <th class="px-4 py-2 font-semibold">Featured Image</th>
                        <th class="px-4 py-2 font-semibold">Actions</th>
                    </tr>
                </thead>

                {{-- Tbody --}}
                <tbody>
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2"></td>
                    </tr>
                </tbody>


            </table>
        </div>

        {{-- Include product modal form --}}
        @include('products.partials.product-modal')

        {{-- If any errors --}}
        @if ($errors->any())
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.store('productStore', {
                        isModalOpen: true,
                    });
                });
            </script>
        @endif

    </div>
@endsection

@push('scripts')
    <script>
        function productManager() {
            return {
                //Alpine state
                isModalOpen: false,
                mode: 'create',
                modalTitle: 'Create Product',
                form: productManager.defaultForm(),
                imagePreviews: [],
                errors: [],

                //Init lifecycle
                init() {
                    if (Alpine.store('productStore')?.isModalOpen) {
                        this.openModal('create');
                        Alpine.store('productStore').isModalOpen = false;
                    }
                },

                //open modal
                openModal(type) {
                    this.isModalOpen = true;
                },

                //Close Modal
                closeModal() {
                    this.isModalOpen = false;
                },

                //Handle image
                handleImage(event) {
                    const files = Array.from(event.target.files);

                    //File handling
                    this.processFilesHandling(files);
                },

                //Handle drop
                handleDrop(event) {
                    const files = Array.from(event.dataTransfer.files);

                    //File handling
                    this.processFilesHandling(files);

                    //Attaching dropped files to the actual file input 
                    const dataTransfer = new dataTransfer();
                    files.forEach(file => dataTransfer.items.add(file));
                    this.$refs.fileInput.files = dataTransfer.files;
                },

                //Process file Handling
                processFilesHandling(files) {
                    files.forEach(file => {
                        if (file.type.startsWith('image/')) {
                            this.form.images.push(file);
                            this.imagePreviews.push({
                                url: URL.createObjectURL(file),
                                type: 'new',
                                file
                            });
                        } else {
                            this.errors.push(`$ {
                                file.name
                            }
                            is not a valid image file.`);

                        }
                    })
                },

                //Handle image remove
                removeImage(index) {
                    const image = this.imagePreviews[index];

                    if (image.type === 'existing') {
                        this.form.existingImages = this.form.existingImages.filter(path => path !== image.featured_image);
                    } else if (image.type === 'new') {
                        const fileIndex = this.form.images.findIndex(file => URL.createObjectURL(file) === image.url);

                        if (fileIndex !== -1) {
                            this.form.images.splice(fileIndex, 1);
                        }
                    }

                    this.imagePreviews.splice(index, 1);
                }
            };
        }

        //Reusable state
        productManager.defaultForm = function() {
            return {
                name: '',
                price: '',
                status: '',
                description: '',
                images: [],
                existingImages: [],
            };
        }
    </script>
@endpush
