{{-- File: platform/themes/hously/views/real-estate/property.blade.php --}}

{{-- Jika masih ada error dengan layout, gunakan template sederhana ini --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $property->name }}</title>
    
    {{-- Include CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
    
    <style>
        /* Property Gallery Modal Styles */
        #property-gallery-modal {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        
        /* Modal Header */
        #property-gallery-modal .absolute.top-0 {
            background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
            padding: 1.5rem 1rem 3rem;
        }
        
        /* Navigation Buttons */
        #property-gallery-modal button[onclick*="navigate"] {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        #property-gallery-modal button[onclick*="navigate"]:hover {
            background-color: rgba(0,0,0,0.7);
            transform: scale(1.1);
            border-color: rgba(255,255,255,0.2);
        }
        
        /* Close Button */
        #property-gallery-modal button[onclick="closePropertyGallery()"] {
            transition: all 0.2s ease;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            background-color: rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        
        #property-gallery-modal button[onclick="closePropertyGallery()"]:hover {
            background-color: rgba(255,255,255,0.2);
            transform: scale(1.1);
        }
        
        /* Gallery Content */
        #gallery-content {
            padding: 2rem;
            max-width: calc(100vw - 8rem);
            max-height: calc(100vh - 12rem);
        }
        
        #gallery-content img {
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        #gallery-content video {
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);
            outline: none;
        }
        
        #gallery-content iframe {
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);
        }
        
        /* Button styles */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .btn-icon {
            width: 3rem;
            height: 3rem;
            padding: 0;
        }
        
        .bg-primary {
            background-color: #3b82f6;
        }
        
        .bg-primary:hover {
            background-color: #2563eb;
        }
        
        .bg-secondary:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="min-h-screen">
    {{-- Property Media Gallery --}}
    <div class="relative">
        {!! Theme::partial('real-estate.properties.slider', ['item' => $property]) !!}
    </div>

    {{-- Property Details --}}
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $property->name }}</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-3">Property Details</h2>
                    
                    <div class="space-y-2">
                        @if ($property->city_id)
                            <div class="flex items-center">
                                <i class="mdi mdi-map-marker-outline text-blue-500 mr-2"></i>
                                <span>{{ $property->city->name }}</span>
                            </div>
                        @endif
                        
                        @if ($property->number_bedroom)
                            <div class="flex items-center">
                                <i class="mdi mdi-bed-empty text-blue-500 mr-2"></i>
                                <span>{{ number_format($property->number_bedroom) }} Bedrooms</span>
                            </div>
                        @endif
                        
                        @if ($property->number_bathroom)
                            <div class="flex items-center">
                                <i class="mdi mdi-shower text-blue-500 mr-2"></i>
                                <span>{{ number_format($property->number_bathroom) }} Bathrooms</span>
                            </div>
                        @endif
                        
                        @if ($property->square)
                            <div class="flex items-center">
                                <i class="mdi mdi-arrow-expand-all text-blue-500 mr-2"></i>
                                <span>{{ $property->square_text }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h2 class="text-xl font-semibold mb-3">Price Information</h2>
                    <div class="text-2xl font-bold text-blue-600">{{ $property->price_html }}</div>
                    
                    @if($property->author)
                        <div class="mt-6">
                            <h3 class="font-semibold mb-2">Agent Information</h3>
                            <div class="flex items-center">
                                <img src="{{ $property->author->avatar_url }}" 
                                     class="w-12 h-12 rounded-full mr-3" 
                                     alt="{{ $property->author->name }}">
                                <div>
                                    <div class="font-medium">{{ $property->author->name }}</div>
                                    @if($property->author->phone)
                                        <div class="text-gray-600">{{ $property->author->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            @if ($property->description)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-3">Description</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! BaseHelper::clean($property->description) !!}
                    </div>
                </div>
            @endif

            @if ($property->features->count())
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-3">Property Features</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($property->features as $feature)
                            <div class="flex items-center">
                                @if($feature->icon)
                                    <i class="{{ $feature->icon }} text-blue-500 mr-2"></i>
                                @endif
                                <span>{{ $feature->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>