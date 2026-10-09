@extends('layouts.storefront')

@section('title', 'Transportation & Global Logistics — Shiv Aaradhana Private Limited')
@section('meta_description', 'Reliable transportation solutions connecting India\'s agricultural heartlands with global markets through road, air, and sea logistics.')

@section('content')

<!-- Hero Section -->
<section class="relative bg-[#091433] text-white pt-16 pb-24 md:pt-24 md:pb-32 overflow-hidden border-b border-stone-800">
    <!-- Atmospheric subtle background glow -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-[#394F3D]/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-[#9C451B]/25 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="text-xs text-stone-400 mb-6 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-[#EBD6B4] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#EBD6B4] font-medium">Logistics & Transportation</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#394F3D]/60 border border-[#EBD6B4]/30 text-xs text-[#EBD6B4] font-medium tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-[#EBD6B4] animate-pulse"></span>
                    Multimodal Export Logistics Infrastructure
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-heading font-extrabold text-white tracking-tight leading-[1.15]">
                    Moving India's Products to the World.
                </h1>

                <p class="text-base sm:text-lg text-stone-300 font-light leading-relaxed max-w-2xl">
                    Reliable transportation solutions connecting India's agricultural heartlands with global markets through road, air, and sea logistics.
                </p>

                <!-- Action CTAs -->
                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <button @click="triggerQuote('', '')" class="px-7 py-3.5 rounded-lg bg-[#9C451B] hover:bg-[#b85322] text-white font-medium text-sm shadow-xl shadow-black/30 transition-all transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                        <span>Request a Freight Quote</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <a href="#transport-modes" class="px-7 py-3.5 rounded-lg bg-white/10 hover:bg-white/20 text-[#EBD6B4] border border-[#EBD6B4]/40 font-medium text-sm backdrop-blur-sm transition-all inline-flex items-center justify-center">
                        Explore Transport Modes &darr;
                    </a>
                </div>

                <!-- Strategic Gateway Stats -->
                <div class="pt-8 grid grid-cols-2 sm:grid-cols-4 gap-4 border-t border-stone-800">
                    <div>
                        <div class="text-xl sm:text-2xl font-heading font-bold text-[#EBD6B4]">3 Major Ports</div>
                        <div class="text-[11px] uppercase tracking-wider text-stone-400 mt-0.5">Mundra &bull; Kandla &bull; Pipavav</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-heading font-bold text-white">100% Tracked</div>
                        <div class="text-[11px] uppercase tracking-wider text-stone-400 mt-0.5">Farm-to-Port Route</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-heading font-bold text-white">3 Modes</div>
                        <div class="text-[11px] uppercase tracking-wider text-stone-400 mt-0.5">Road, Air & Sea Freight</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-heading font-bold text-[#EBD6B4]">Global Reach</div>
                        <div class="text-[11px] uppercase tracking-wider text-stone-400 mt-0.5">50+ Destinations</div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Visual -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto rounded-2xl overflow-hidden shadow-2xl border border-[#EBD6B4]/25 bg-stone-900 group">
                    <img src="/images/transport/sea-transport.jpg" 
                         alt="Shiv Aaradhana International Logistics" 
                         class="w-full h-96 sm:h-[460px] object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#091433] via-transparent to-transparent"></div>
                    
                    <div class="absolute bottom-6 left-6 right-6 p-5 rounded-xl bg-[#091433]/90 backdrop-blur-md border border-white/10 text-white space-y-1">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#EBD6B4] block">Gujarat Port Proximity</span>
                        <h4 class="font-heading font-bold text-base">Direct Maritime Access</h4>
                        <p class="text-xs text-stone-300">Located in Rajkot, offering high-speed highway connectivity to Western India's primary deep-water container ports.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Transportation Overview Section -->
<section id="transport-modes" class="py-20 bg-[#F7F3EC] border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-xs uppercase tracking-widest font-bold text-[#9C451B]">Integrated Global Logistics</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-[#091433] tracking-tight">
                Choose Your Way of Transport
            </h2>
            <div class="w-16 h-1 bg-[#9C451B] mx-auto rounded"></div>
            <p class="text-sm sm:text-base text-stone-600 leading-relaxed pt-2">
                We coordinate specialized transit solutions designed around commodity sensitivity, order volume, destination port requirements, and delivery urgency.
            </p>
        </div>

        <!-- 3 Premium Transportation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- 01 — ROAD -->
            <div class="group bg-white rounded-2xl border border-stone-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <!-- Card Image -->
                    <div class="h-60 overflow-hidden relative bg-stone-100">
                        <img src="/images/transport/road-transport.jpg" 
                             alt="Road Transportation — Shiv Aaradhana" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#091433] text-[#EBD6B4] text-xs font-mono font-bold tracking-wider shadow">
                            01 &mdash; ROAD
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 sm:p-7 space-y-4">
                        <div>
                            <span class="text-[11px] uppercase tracking-wider font-bold text-[#9C451B] block">Regional & Domestic</span>
                            <h3 class="font-heading font-bold text-2xl text-[#091433] group-hover:text-[#9C451B] transition-colors mt-0.5">
                                Road Transportation
                            </h3>
                        </div>

                        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                            Reliable regional and domestic transportation connecting farms, processing facilities, warehouses, ports, and distribution points.
                        </p>

                        <!-- Key Bullets -->
                        <div class="pt-2 border-t border-stone-100 space-y-2.5">
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Farm-to-warehouse transportation</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Warehouse-to-port movement</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Flexible pickup and delivery</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Suitable for short and medium distances</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer CTA -->
                <div class="p-6 sm:p-7 pt-0 border-t border-stone-100 mt-2">
                    <button @click="triggerQuote('', 'Road Transportation')" class="w-full py-2.5 px-4 rounded-lg bg-[#091433] hover:bg-[#394F3D] text-[#EBD6B4] hover:text-white font-medium text-xs transition-colors flex items-center justify-center gap-1.5 shadow">
                        <span>Inquire Road Transit</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            <!-- 02 — AIRWAY -->
            <div class="group bg-white rounded-2xl border border-stone-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <!-- Card Image -->
                    <div class="h-60 overflow-hidden relative bg-stone-100">
                        <img src="/images/transport/air-transport.jpg" 
                             alt="Air Transportation — Shiv Aaradhana" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#091433] text-[#EBD6B4] text-xs font-mono font-bold tracking-wider shadow">
                            02 &mdash; AIRWAY
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 sm:p-7 space-y-4">
                        <div>
                            <span class="text-[11px] uppercase tracking-wider font-bold text-[#9C451B] block">Express International</span>
                            <h3 class="font-heading font-bold text-2xl text-[#091433] group-hover:text-[#9C451B] transition-colors mt-0.5">
                                Air Transportation
                            </h3>
                        </div>

                        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                            Fast international transportation for urgent and time-sensitive shipments.
                        </p>

                        <!-- Key Bullets -->
                        <div class="pt-2 border-t border-stone-100 space-y-2.5">
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Rapid international delivery</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Suitable for urgent shipments</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Ideal for high-value products</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Suitable for smaller-volume shipments</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer CTA -->
                <div class="p-6 sm:p-7 pt-0 border-t border-stone-100 mt-2">
                    <button @click="triggerQuote('', 'Air Transportation')" class="w-full py-2.5 px-4 rounded-lg bg-[#091433] hover:bg-[#394F3D] text-[#EBD6B4] hover:text-white font-medium text-xs transition-colors flex items-center justify-center gap-1.5 shadow">
                        <span>Inquire Air Cargo</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            <!-- 03 — SEAWAYS -->
            <div class="group bg-white rounded-2xl border border-stone-200/90 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <!-- Card Image -->
                    <div class="h-60 overflow-hidden relative bg-stone-100">
                        <img src="/images/transport/sea-transport.jpg" 
                             alt="Sea Transportation — Shiv Aaradhana" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#091433] text-[#EBD6B4] text-xs font-mono font-bold tracking-wider shadow">
                            03 &mdash; SEAWAYS
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 sm:p-7 space-y-4">
                        <div>
                            <span class="text-[11px] uppercase tracking-wider font-bold text-[#9C451B] block">Bulk Global Maritime</span>
                            <h3 class="font-heading font-bold text-2xl text-[#091433] group-hover:text-[#9C451B] transition-colors mt-0.5">
                                Sea Transportation
                            </h3>
                        </div>

                        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                            Efficient international transportation for large-volume export shipments.
                        </p>

                        <!-- Key Bullets -->
                        <div class="pt-2 border-t border-stone-100 space-y-2.5">
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Containerized shipping</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Suitable for bulk agricultural products</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Cost-effective international logistics</span>
                            </div>
                            <div class="flex items-start gap-2.5 text-xs text-stone-700">
                                <span class="text-[#394F3D] font-bold mt-0.5">&#10003;</span>
                                <span>Access to major Indian ports</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer CTA -->
                <div class="p-6 sm:p-7 pt-0 border-t border-stone-100 mt-2">
                    <button @click="triggerQuote('', 'Sea Transportation')" class="w-full py-2.5 px-4 rounded-lg bg-[#091433] hover:bg-[#394F3D] text-[#EBD6B4] hover:text-white font-medium text-xs transition-colors flex items-center justify-center gap-1.5 shadow">
                        <span>Inquire Ocean Freight</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Detailed Breakdown: Road -> Airway -> Seaways -->
<section class="py-20 bg-white border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        
        <!-- Road Deep-Dive -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs uppercase tracking-widest font-bold text-[#9C451B]">Section 01 &bull; Regional Network</span>
                <h3 class="text-2xl sm:text-3xl font-heading font-bold text-[#091433]">
                    Inland Road Freight: Farm-to-Port Synchronization
                </h3>
                <div class="w-12 h-1 bg-[#9C451B] rounded"></div>
                <p class="text-sm text-stone-600 leading-relaxed">
                    Our Rajkot operational center serves as the nerve center for agricultural collection across Saurashtra. With dedicated regional transport, raw commodities move swiftly from harvest collection points into processing and Sortex facilities without environmental degradation.
                </p>
                <div class="grid grid-cols-2 gap-3 pt-2 text-xs">
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-[#091433] block">Direct Mandi Aggregation</span>
                        <span class="text-stone-500 mt-0.5 block">Zero third-party transit delays from Gondal, Rajkot, and Jamnagar farming belts.</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-[#091433] block">Covered Container Fleets</span>
                        <span class="text-stone-500 mt-0.5 block">Weather-sealed transport preventing moisture absorption during transit.</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-6">
                <div class="rounded-2xl overflow-hidden shadow-lg border border-stone-200">
                    <img src="/images/transport/road-transport.jpg" alt="Inland road transportation" class="w-full h-80 object-cover">
                </div>
            </div>
        </div>

        <!-- Airway Deep-Dive -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 order-2 lg:order-1">
                <div class="rounded-2xl overflow-hidden shadow-lg border border-stone-200">
                    <img src="/images/transport/air-transport.jpg" alt="International air freight" class="w-full h-80 object-cover">
                </div>
            </div>
            <div class="lg:col-span-6 order-1 lg:order-2 space-y-4">
                <span class="text-xs uppercase tracking-widest font-bold text-[#9C451B]">Section 02 &bull; Express Air Cargo</span>
                <h3 class="text-2xl sm:text-3xl font-heading font-bold text-[#091433]">
                    Airway Logistics: Rapid Dispatch for High-Value Cargo
                </h3>
                <div class="w-12 h-1 bg-[#9C451B] rounded"></div>
                <p class="text-sm text-stone-600 leading-relaxed">
                    When transit time is critical, our air freight corridors through international air hubs (including Ahmedabad and Mumbai) provide direct connections to Middle Eastern, European, and American destinations.
                </p>
                <div class="grid grid-cols-2 gap-3 pt-2 text-xs">
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-[#091433] block">Pre-Flight Purity Inspection</span>
                        <span class="text-stone-500 mt-0.5 block">Immediate quarantine checks and laboratory certification for expedited release.</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-[#091433] block">Temperature Monitored</span>
                        <span class="text-stone-500 mt-0.5 block">Ideal for organic spices, botanical extracts, and time-sensitive buyer samples.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seaways Deep-Dive -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs uppercase tracking-widest font-bold text-[#9C451B]">Section 03 &bull; Global Maritime Corridors</span>
                <h3 class="text-2xl sm:text-3xl font-heading font-bold text-[#091433]">
                    Ocean Freight: High-Capacity Containerized Dispatches
                </h3>
                <div class="w-12 h-1 bg-[#9C451B] rounded"></div>
                <p class="text-sm text-stone-600 leading-relaxed">
                    Ocean transport accounts for the bulk of our export volume. Direct access to Mundra, Kandla, and Pipavav deep-water ports allows Shiv Aaradhana to offer advantageous freight rates and reliable vessel liner allocations.
                </p>
                <div class="grid grid-cols-2 gap-3 pt-2 text-xs">
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-[#091433] block">20ft / 40ft FCL Loading</span>
                        <span class="text-stone-500 mt-0.5 block">Factory-stuffed and port-stuffed dry containers with heavy-duty desiccants.</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-[#091433] block">Port-Side Fumigation</span>
                        <span class="text-stone-500 mt-0.5 block">Government-approved phytosanitary treatments and tamper-evident container sealing.</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-6">
                <div class="rounded-2xl overflow-hidden shadow-lg border border-stone-200">
                    <img src="/images/transport/sea-transport.jpg" alt="Ocean cargo vessel and container port" class="w-full h-80 object-cover">
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Why Choose Our Logistics Section -->
<section class="py-20 bg-[#FAF5ED] border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-xs uppercase tracking-widest font-bold text-[#9C451B]">Our Operational Edge</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-[#091433] tracking-tight">
                Why Choose Our Logistics
            </h2>
            <div class="w-16 h-1 bg-[#9C451B] mx-auto rounded"></div>
            <p class="text-sm sm:text-base text-stone-600 leading-relaxed pt-2">
                International trade demands rigorous logistical control. We eliminate uncertainties with strategic port access, meticulous handling, and direct operational governance.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="p-6 rounded-2xl bg-white border border-stone-200 shadow-sm space-y-3 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-lg bg-[#394F3D]/10 text-[#394F3D] flex items-center justify-center font-bold text-lg">
                    01
                </div>
                <h4 class="font-heading font-bold text-base text-[#091433]">Strategic Port Proximity</h4>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Under 240 km from Mundra, Kandla, and Pipavav ports. Shorter transit minimizes inland costs and port cutoff risks.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-stone-200 shadow-sm space-y-3 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-lg bg-[#394F3D]/10 text-[#394F3D] flex items-center justify-center font-bold text-lg">
                    02
                </div>
                <h4 class="font-heading font-bold text-base text-[#091433]">Moisture & Fumigation Care</h4>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Multi-layer kraft paper, food-grade PP liners, silica desiccants, and certified methyl bromide / phosphine treatments.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-stone-200 shadow-sm space-y-3 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-lg bg-[#394F3D]/10 text-[#394F3D] flex items-center justify-center font-bold text-lg">
                    03
                </div>
                <h4 class="font-heading font-bold text-base text-[#091433]">Transparent Documentation</h4>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Rapid processing of Bills of Lading, Certificate of Origin, Certificate of Analysis, Phytosanitary, and SGS inspections.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-stone-200 shadow-sm space-y-3 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-lg bg-[#394F3D]/10 text-[#394F3D] flex items-center justify-center font-bold text-lg">
                    04
                </div>
                <h4 class="font-heading font-bold text-base text-[#091433]">Dedicated Export Desk</h4>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Single point of contact managing vessel bookings, customs clearances, container tracking, and destination coordination.
                </p>
            </div>

        </div>

    </div>
</section>

<!-- Final CTA Section -->
<section class="py-16 bg-[#561118] text-white text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <span class="text-xs uppercase tracking-widest font-bold text-[#EBD6B4] block">International Trade Coordination</span>
        <h2 class="text-3xl sm:text-4xl font-heading font-bold text-white tracking-tight">
            Ready to Move Your Products Globally?
        </h2>
        <p class="text-sm sm:text-base text-stone-200 max-w-2xl mx-auto leading-relaxed">
            Whether seeking full container sea shipments, priority air freight, or regional road dispatches, our trade desk is ready to provide transparent terms, scheduled loading, and competitive CIF/FOB pricing.
        </p>
        <div class="pt-3 flex flex-wrap justify-center gap-4">
            <button @click="triggerQuote('', 'Multimodal Transportation Inquiry')" class="px-8 py-3.5 rounded-lg bg-[#EBD6B4] hover:bg-white text-[#091433] font-bold text-sm shadow-xl transition-all transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                <span>Request a Quote</span>
                <span>&rarr;</span>
            </button>
            <a href="{{ route('contact') }}" class="px-8 py-3.5 rounded-lg bg-transparent hover:bg-white/10 text-white border border-white/40 font-medium text-sm transition-all inline-flex items-center justify-center">
                Contact Logistics Desk
            </a>
        </div>
    </div>
</section>

@endsection
