<div x-show="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-8">

        <h2 class="text-2xl font-bold mb-6">Create Product</h2>

        {{-- Form --}}

        <form action="">


            {{-- Product name --}}
            <div class="mb-3">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>

                <input type="text" name="name" id="name"
                    class="w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-purple-500"
                    placeholder="Product Name">
            </div>

            {{-- price and status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                {{-- Price --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>

                    <input type="text" id="price" name="price"
                        class="w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-purple-500"
                        placeholder="Product Price">
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>

                    <select name="status" id="status"
                        class="w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-purple-500">

                        <option selected disabled value="">Select</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>

                <textarea name="description" id="description"
                    class="w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-purple-500"
                    placeholder="Description ..."></textarea>
            </div>

            {{-- Image upload --}}
            <div>
                <label for="" block text-sm font-medium text-gray-700 mb-1>Featured Image</label>
                <div @click="$refs.fileInput.click()" @dragover.prevent @drop.prevent="handleDrop($event)"
                    class="w-full border-2 border-dashed border-purple-400 px-5 py-20 rounded-lg text-center bg-gray-50 cursor-pointer hover:bg-gray-100 transition">

                    <input @change="handleImage($event)" type="file" class="hidden" name="images[]" multiple
                        accept="image/*" x-ref="fileInput" />

                    <p class="text-purple-600 font-semibold flex items-center justify-center"><i data-lucide="upload"
                            class="mr-2"></i>Click or Drag Image to Upload</p>

                    <p class="text-xs text-gray-500 mt-1.5">You can select multiple images</p>
                </div>
            </div>


            {{-- Image Preview --}}
            <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4">
                <template x-for="(img, index) in imagePreviews" :key="index">

                    <div class="relative group w-full h-36 rounded overlow-hidden shadow-md border border-gray-300">

                        <img :src="img.url" class="w-full h-full object-cover" />

                    </div>

                </template>
            </div>


            {{-- Buttons --}}
            <div class="flex justify-end space-x-3 pt-4">
                <button @click="closeModal" type="button"
                    class="cursor-pointer bg-gray-300 hover:bg-gray-400 text-black px-6 py-2 rounded shadow">Cancel</button>
                <button type="submit"
                    class="cursor-pointer bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded shadow transition">Save</button>
            </div>

        </form>

    </div>

</div>
