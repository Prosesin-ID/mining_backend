@extends('layouts.app')

@section('content')
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 25px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #D4AF37;
        }

        .stat-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }

        .stat-change {
            font-size: 13px;
            color: #4ade80;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 28px;
            height: 28px;
            fill: #D4AF37;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .activity-card,
        .status-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 25px;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #2a2a2a;
        }

        .card-header svg {
            width: 24px;
            height: 24px;
            fill: #D4AF37;
        }

        .card-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab {
            padding: 8px 16px;
            background: transparent;
            border: 1px solid #2a2a2a;
            color: #888;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
        }

        .tab.active {
            background: #D4AF37;
            color: #000;
            border-color: #D4AF37;
            font-weight: 600;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: rgba(30, 30, 30, 0.5);
            border: 1px solid #2a2a2a;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .activity-item:hover {
            background: rgba(40, 40, 40, 0.7);
            border-color: #D4AF37;
        }

        .activity-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .activity-status {
            width: 12px;
            height: 12px;
            background: #4ade80;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .activity-details h4 {
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 5px 0;
        }

        .activity-details p {
            font-size: 12px;
            color: #888;
            margin: 0;
        }

        .activity-badge {
            padding: 6px 14px;
            background: rgba(74, 222, 128, 0.15);
            color: #4ade80;
            border: 1px solid #4ade80;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .activity-badge.checkout {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border-color: #ef4444;
        }

        .activity-time {
            font-size: 13px;
            color: #888;
            margin-left: 10px;
        }

        .status-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            background: rgba(30, 30, 30, 0.5);
            border: 1px solid #2a2a2a;
            border-radius: 8px;
        }

        .status-item span {
            font-size: 14px;
            color: #ccc;
        }

        .status-count {
            font-size: 18px;
            font-weight: 700;
            color: #4ade80;
        }

        .maintenance-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .maintenance-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 25px;
        }

        .maintenance-item {
            padding: 15px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid #ef4444;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .maintenance-item:last-child {
            margin-bottom: 0;
        }

        .maintenance-item h4 {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 8px 0;
        }

        .maintenance-meta {
            font-size: 12px;
            color: #888;
            margin-bottom: 8px;
        }

        .maintenance-reason {
            font-size: 13px;
            color: #ccc;
            font-style: italic;
        }

        .map-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 25px;
            height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .map-placeholder {
            text-align: center;
            color: #888;
        }

        .map-placeholder svg {
            width: 80px;
            height: 80px;
            fill: #444;
            margin-bottom: 15px;
        }

        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .maintenance-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="background: rgba(74, 222, 128, 0.15); border: 1px solid #4ade80; color: #4ade80;">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-label">Total Unit</div>
            <div class="stat-value">{{ $trucks }}</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z" />
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Checkpoints</div>
            <div class="stat-value">{{ $checkpoints }}</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">On Location</div>
            <div class="stat-value">{{ $onLocationDrivers }}</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Maintenance</div>
            <div class="stat-value">{{ $maintenanceTrucks }}</div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Activity and Status -->
    <div class="content-grid">
        <div class="activity-card">
            <div class="card-header">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                </svg>
                <h3>AKTIVITAS TERKINI</h3>
            </div>

            <div class="tabs">
                <div class="tab active">Semua</div>
                <div class="tab">Check-Out Data</div>
            </div>

            <div class="activity-list">
                @foreach($logs as $log)
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-status"></div>
                            <div class="activity-details">
                                <h4>{{ $log->driver?->unitTruck?->plate_number ?? '-' }}</h4>
                                <p>{{ $log->driver->name ?? '-' }} • {{ $log->checkPoint->name ?? '-' }}</p>

                            </div>
                        </div>
                        <div style="display: flex; align-items: center;">
                            @if($log->last_activity === 'check_in')
                                <span class="activity-badge">CHECK-IN</span>
                                <span class="activity-time">{{ \Carbon\Carbon::parse($log->check_In)->format('H:i') }}</span>
                            @else
                                <span class="activity-badge checkout">CHECK-OUT</span>
                                <span class="activity-time">{{ \Carbon\Carbon::parse($log->check_Out)->format('H:i') }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="status-card">
            <div class="card-header">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z" />
                </svg>
                <h3>STATUS UNIT</h3>
            </div>

            <div class="status-list">
                <div class="status-item">
                    <span>On Location</span>
                    <span class="status-count" style="color: #4ade80;">{{ $onLocationDrivers }}</span>
                </div>
                <div class="status-item">
                    <span>Belum Check-Out</span>
                    <span class="status-count" style="color: #f59e0b;">{{ $notCheckOutDrivers }}</span>
                </div>
                <div class="status-item">
                    <span>Maintenance</span>
                    <span class="status-count" style="color: #ef4444;">{{ $maintenanceTrucks }}</span>
                </div>
                <div class="status-item">
                    <span>Completed</span>
                    <span class="status-count" style="color: #3b82f6;">{{ $completedDrivers }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Units -->
    <div class="maintenance-grid">
        <div class="maintenance-card">
            <div class="card-header">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z" />
                </svg>
                <h3>UNIT MAINTENANCE</h3>
            </div>
            @foreach ($mtTruckDatas as $mt)
                <div class="maintenance-item">
                    <h4>{{ $mt->plate_number }}</h4>
                    <div class="maintenance-meta">Sejak {{ \Carbon\Carbon::parse($mt->maintenance_start_time)->format('H:i') }}
                        • {{ $mt->driver->name }}</div>
                    <div class="maintenance-reason">Alasan: {{ $mt->reason_maintenance }}</div>
                </div>
            @endforeach
        </div>

        <div class="map-card">
            <div class="card-header" style="border: none; padding-bottom: 10px; margin-bottom: 0;">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z" />
                </svg>
                <h3>PETA MONITORING</h3>
            </div>
            <div id="map" style="width: 100%; height: 350px; border-radius: 8px;"></div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    <script>
        let map;
        let markers = {};
        let userLocation = null;

        // Initialize map
        function initMap() {
            // Default center (Indonesia)
            const defaultCenter = { lat: -2.5489, lng: 118.0149 };
            
            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        console.log('📍 User location detected:', userLocation);
                        
                        // Initialize map with user location
                        createMap(userLocation);
                        
                        // Add user location marker
                        new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: 'Lokasi Anda',
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 8,
                                fillColor: '#3b82f6',
                                fillOpacity: 1,
                                strokeColor: '#fff',
                                strokeWeight: 2
                            }
                        });
                    },
                    (error) => {
                        console.warn('⚠️ Could not get user location:', error.message);
                        createMap(defaultCenter);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                console.warn('⚠️ Geolocation not supported');
                createMap(defaultCenter);
            }
        }

        function createMap(center) {
            map = new google.maps.Map(document.getElementById('map'), {
                center: center,
                zoom: userLocation ? 12 : 5,
                styles: [
                    {
                        "featureType": "all",
                        "elementType": "geometry",
                        "stylers": [{"color": "#242f3e"}]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.text.stroke",
                        "stylers": [{"color": "#242f3e"}]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#746855"}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{"color": "#17263c"}]
                    }
                ]
            });

            // Load initial markers
            updateMarkers();
        }

        // Update markers from API
        async function updateMarkers() {
            try {
                const response = await fetch('{{ route('location.active') }}');
                const result = await response.json();
                
                if (result.success && result.data) {
                    console.log(`📍 Loaded ${result.count} active driver locations`);
                    
                    // Clear old markers that no longer exist
                    const currentDriverIds = result.data.map(d => d.driver_id);
                    for (const driverId in markers) {
                        if (!currentDriverIds.includes(parseInt(driverId))) {
                            markers[driverId].marker.setMap(null);
                            markers[driverId].label.setMap(null);
                            delete markers[driverId];
                        }
                    }
                    
                    // Add or update markers
                    result.data.forEach(driver => {
                        const position = {
                            lat: driver.latitude,
                            lng: driver.longitude
                        };
                        
                        if (markers[driver.driver_id]) {
                            // Update existing marker position
                            markers[driver.driver_id].marker.setPosition(position);
                            markers[driver.driver_id].label.setPosition(position);
                        } else {
                            // Marker color: gold if checked in, orange if not
                            const markerColor = driver.is_checked_in ? '#D4AF37' : '#f59e0b';
                            
                            // Create new marker with label
                            const marker = new google.maps.Marker({
                                position: position,
                                map: map,
                                title: driver.plate_number,
                                icon: {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    scale: 10,
                                    fillColor: markerColor,
                                    fillOpacity: 1,
                                    strokeColor: '#fff',
                                    strokeWeight: 2
                                }
                            });
                            
                            // Add label above marker
                            const label = new google.maps.Marker({
                                position: position,
                                map: map,
                                icon: {
                                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="30">
                                            <rect width="120" height="30" rx="15" fill="${markerColor}" opacity="0.9"/>
                                            <text x="60" y="20" font-family="Arial" font-size="12" font-weight="bold" 
                                                  fill="#000" text-anchor="middle">${driver.driver_name}</text>
                                        </svg>
                                    `),
                                    anchor: new google.maps.Point(60, 45),
                                    labelOrigin: new google.maps.Point(60, 15)
                                }
                            });
                            
                            // Info window
                            const infoWindow = new google.maps.InfoWindow({
                                content: `
                                    <div style="color: #000; padding: 10px;">
                                        <h4 style="margin: 0 0 8px 0; color: #D4AF37;">${driver.plate_number}</h4>
                                        <p style="margin: 4px 0;"><strong>Driver:</strong> ${driver.driver_name}</p>
                                        <p style="margin: 4px 0;"><strong>Checkpoint:</strong> ${driver.checkpoint_name}</p>
                                        <p style="margin: 4px 0; font-size: 12px; color: #666;">
                                            <strong>Check-in:</strong> ${new Date(driver.check_in_time).toLocaleTimeString('id-ID')}
                                        </p>
                                    </div>
                                `
                            });
                            
                            marker.addListener('click', () => {
                                // Close all other info windows
                                for (const id in markers) {
                                    if (markers[id].infoWindow) {
                                        markers[id].infoWindow.close();
                                    }
                                }
                                infoWindow.open(map, marker);
                            });
                            
                            markers[driver.driver_id] = {
                                marker: marker,
                                label: label,
                                infoWindow: infoWindow
                            };
                        }
                    });
                    
                    // Auto-fit bounds if there are markers
                    if (result.data.length > 0) {
                        const bounds = new google.maps.LatLngBounds();
                        result.data.forEach(driver => {
                            bounds.extend({
                                lat: driver.latitude,
                                lng: driver.longitude
                            });
                        });
                        map.fitBounds(bounds);
                        
                        // Don't zoom in too much
                        google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                            if (this.getZoom() > 15) {
                                this.setZoom(15);
                            }
                        });
                    }
                }
            } catch (error) {
                console.error('❌ Error loading driver locations:', error);
            }
        }

        // Initialize on page load
        window.onload = initMap;
        
        // Auto-refresh every 30 seconds
        setInterval(updateMarkers, 30000);
    </script>

@endsection