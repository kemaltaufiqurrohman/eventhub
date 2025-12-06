<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview Template Sertifikat — Desktop') }}
        </h2>
    </x-slot>

    <style>
        .preview-area { background:#f7fafc; border-radius:8px; }
        .grid-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(0,0,0,0.06) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(0,0,0,0.06) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 20;
        }
        .hidden-grid { display: none; }
        .name-bbox { outline: 1px dashed rgba(0,0,0,0.35); padding: 4px; border-radius: 4px; }
        #namePreview { cursor: grab; user-select: none; z-index: 30; white-space: pre-wrap; }
        #namePreview.dragging { cursor: grabbing; }
        .preview-scroll { max-height: 720px; overflow: auto; border-radius: 6px; }
        .template-image { display:block; max-width:none; height:auto; }
        .small-btn { padding:6px 10px; border-radius:6px; border:1px solid #e2e8f0; background:#fff; }

        /* 🔥 Sticky bottom bar */
        .sticky-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: white;
            padding: 14px 24px;
            box-shadow: 0 -3px 10px rgba(0,0,0,0.1);
            z-index: 999;
        }
    </style>

    <div class="py-8 pb-24"> 
        <div class="max-w-7xl mx-auto bg-white shadow rounded p-6">

            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-600">Preview template sertifikat — desktop view</p>
                </div>

                <div class="flex gap-2 items-center">
                    <button id="zoomOut" class="small-btn">-</button>
                    <div id="zoomLabel" class="px-3 text-sm">100%</div>
                    <button id="zoomIn" class="small-btn">+</button>

                    <button id="toggleGrid" class="small-btn">Grid</button>
                    <button id="toggleBBox" class="small-btn">BBox</button>
                </div>
            </div>

            @if ($event->certificate_template)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="md:col-span-2">
                        <div class="preview-area p-3 preview-scroll relative">
                            <div id="scaleWrapper" style="transform-origin: top left;">
                                <div id="imageCanvas" class="relative" style="display:inline-block;">
                                    <div id="gridOverlay" class="grid-overlay hidden-grid"></div>

                                    <img id="templateImage"
                                         class="template-image"
                                         src="{{ asset('storage/' . $event->certificate_template) }}"
                                         alt="Template Sertifikat">

                                    <div id="namePreview"
                                         class="name-bbox"
                                         style="
                                             position:absolute;
                                             left: {{ $event->text_x ?? 100 }}px;
                                             top: {{ $event->text_y ?? 100 }}px;
                                             font-size: {{ $event->text_size ?? 32 }}px;
                                             color: {{ $event->text_color ?? '#222222' }};
                                             max-width: 80%;
                                         ">
                                        NAMA PESERTA
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="bg-gray-50 p-4 rounded shadow-sm">
                            <h4 class="font-semibold mb-2">Pengaturan</h4>

                            <label class="block text-sm font-medium mb-1">X (px)</label>
                            <input id="inputX" type="number" class="w-full border rounded px-2 py-1 mb-2" value="{{ $event->text_x ?? 100 }}">

                            <label class="block text-sm font-medium mb-1">Y (px)</label>
                            <input id="inputY" type="number" class="w-full border rounded px-2 py-1 mb-2" value="{{ $event->text_y ?? 100 }}">

                            <label class="block text-sm font-medium mb-1">Font size (px)</label>
                            <input id="inputSize" type="number" class="w-full border rounded px-2 py-1 mb-2" value="{{ $event->text_size ?? 32 }}">

                            <label class="block text-sm font-medium mb-1">Warna teks</label>
                            <input id="inputColor" type="color" class="w-20 h-10 p-0 mb-3" value="{{ $event->text_color ?? '#222222' }}">

                            <div class="mb-3">
                                <label class="block text-sm font-medium mb-1">Multi-line</label>
                                <select id="multiLineMode" class="w-full border rounded px-2 py-1">
                                    <option value="both">Wrap & Auto-resize</option>
                                    <option value="wrap">Wrap only</option>
                                    <option value="autoresize">Auto-resize only</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- 🔥 STICKY BOTTOM BAR --}}
    <div class="sticky-bottom-bar">
        <div class="max-w-7xl mx-auto flex justify-between items-center">

            {{-- LEFT: SAVE --}}
            <form id="saveForm" action="{{ route('panitia.events.saveTextSettings', $event->id) }}" method="POST">
                @csrf
                <input type="hidden" name="x" id="saveX">
                <input type="hidden" name="y" id="saveY">
                <input type="hidden" name="text_size" id="saveSize">
                <input type="hidden" name="text_color" id="saveColor">
                <input type="hidden" name="multi_mode" id="saveMultiMode">

                <button type="submit"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    Simpan Pengaturan
                </button>
            </form>

            {{-- RIGHT: GENERATE --}}
            <form action="{{ route('panitia.events.generateCertificates', $event->id) }}" method="POST">
                @csrf
                <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Generate Sertifikat Otomatis
                </button>
            </form>

        </div>
    </div>

    <script>
        (function(){
            const templateImage = document.getElementById('templateImage');
            const scaleWrapper = document.getElementById('scaleWrapper');
            const imageCanvas = document.getElementById('imageCanvas');
            const namePreview = document.getElementById('namePreview');
            const gridOverlay = document.getElementById('gridOverlay');

            const zoomLabel = document.getElementById('zoomLabel');
            const zoomIn = document.getElementById('zoomIn');
            const zoomOut = document.getElementById('zoomOut');
            const toggleGrid = document.getElementById('toggleGrid');
            const toggleBBox = document.getElementById('toggleBBox');

            const inputX = document.getElementById('inputX');
            const inputY = document.getElementById('inputY');
            const inputSize = document.getElementById('inputSize');
            const inputColor = document.getElementById('inputColor');
            const multiLineMode = document.getElementById('multiLineMode');

            const saveX = document.getElementById('saveX');
            const saveY = document.getElementById('saveY');
            const saveSize = document.getElementById('saveSize');
            const saveColor = document.getElementById('saveColor');
            const saveMultiMode = document.getElementById('saveMultiMode');
            const saveForm = document.getElementById('saveForm');

            let zoom = 1.0;
            function setZoom(z){
                zoom = Math.max(0.2, Math.min(3.0, z));
                scaleWrapper.style.transform = `scale(${zoom})`;
                zoomLabel.textContent = Math.round(zoom * 100) + '%';
            }
            zoomIn.onclick = ()=> setZoom(zoom + 0.1);
            zoomOut.onclick =()=> setZoom(zoom - 0.1);
            setZoom(1);

            toggleGrid.onclick =()=> gridOverlay.classList.toggle('hidden-grid');
            toggleBBox.onclick =()=> namePreview.classList.toggle('name-bbox');

            let dragging = false, offsetX=0, offsetY=0;
            namePreview.addEventListener('mousedown',(e)=>{
                dragging = true;
                namePreview.classList.add('dragging');
                const r = namePreview.getBoundingClientRect();
                offsetX = e.clientX - r.left;
                offsetY = e.clientY - r.top;
            });
            document.addEventListener('mouseup',()=>{
                if(dragging){
                    dragging = false;
                    namePreview.classList.remove('dragging');
                    updateHiddenInputs();
                }
            });
            document.addEventListener('mousemove',(e)=>{
                if(!dragging) return;
                const canvasRect = imageCanvas.getBoundingClientRect();
                const left = (e.clientX - canvasRect.left - offsetX)/zoom;
                const top  = (e.clientY - canvasRect.top  - offsetY)/zoom;

                namePreview.style.left = Math.round(left) + 'px';
                namePreview.style.top  = Math.round(top) + 'px';
                inputX.value = Math.round(left);
                inputY.value = Math.round(top);
            });

            function updateFromInputs(){
                namePreview.style.left = inputX.value + 'px';
                namePreview.style.top  = inputY.value + 'px';
                namePreview.style.fontSize = inputSize.value + 'px';
                namePreview.style.color = inputColor.value;
                updateHiddenInputs();
            }
            inputX.oninput = updateFromInputs;
            inputY.oninput = updateFromInputs;
            inputSize.oninput = updateFromInputs;
            inputColor.oninput = updateFromInputs;

            function updateHiddenInputs(){
                saveX.value = inputX.value;
                saveY.value = inputY.value;
                saveSize.value = inputSize.value;
                saveColor.value = inputColor.value;
                saveMultiMode.value = multiLineMode.value;
            }

            saveForm.onsubmit = ()=> updateHiddenInputs();
            updateHiddenInputs();
        })();
    </script>

</x-app-layout>
