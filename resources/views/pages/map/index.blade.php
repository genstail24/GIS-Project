@extends('layout.main')

@push('custom-style')
<!-- select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- leaflet css -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<!-- custom css -->
<style>
  .map-container{
    width: 100%;
    height: 90vh;
  }

  .my-map{
    height: 100%;
    width: 100%;
  }

  .area-list{
    overflow: auto;
  }
  area-detail-container
  @media screen and (min-width:  992px){
    .area-list{
      /*flex-direction:  column !important;*/
      height: 90vh;
    }

    .area-list-item{
      margin-bottom: 5px;
    }

  }
</style>
@endpush

@section('content')
<div class="container-fluid main-content">
  <div class="row">
      <div class="col-md-12 page-header">
          <!-- <div class="page-pretitle">Overview</div> -->
          <h2 class="page-title">Disaster Prone Area</h2>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="form-group">
        <input type="text" name="search_place" placeholder="Search Disaster Prone Area" class="form-control">
      </div>
    </div>  
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <select class="disaster-category-filter" id="disaster-category-filter" name="disaster-category-filter" multiple="multiple" style="width:100%;">
        </select>
      </div>
    </div>  
  </div>
  <div class="row">
    <div class="col-lg-3 col-xl-2 mb-3 mb-lg-0">
      <div class="area-list area-list-container p-1 rounded h-100 bg-white d-flex flex-row flex-lg-column">
        <h4 class="text-center">Area Detail</h4>
        <!-- <div class="area-list-item d-flex justify-content-start align-items-center">
          <a href="#">
            <i class="fas fa-trash"></i>
          </a>
          <a href="#" class="ml-1">
            <i class="fas fa-edit"></i>
          </a>
          <P class="my-auto ml-1 d-flex flex-column">
            <span>name here</span>
            <small>long lat</small>
          </P>
        </div> -->
      </div>
    </div>
    <div class="col-lg map-container">
      <div id="my-map" class="my-map"></div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 d-flex">
      <div class="radio-categories-container d-flex flex-column">
        @foreach($categories as $category)
        <div class="form-check mr-3">
          <input class="form-check-input disaster-category-radio" type="radio" name="disaster-category-radio" id="{{ $category->id }}">
          <label class="form-check-label" for="flexRadioDefault2">
            {{ $category->name }}
          </label>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

@push('custom-script')
<!-- axios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<!-- custom script -->
<script>
  document.addEventListener('DOMContentLoaded', async function() {
    /*
      VANILLA JS
    */
    // access token to mapbox api
    const ACCESS_TOKEN = 'pk.eyJ1IjoibXVoYW1tYWRnZW50YWF0aHRoYXJyaXEiLCJhIjoiY2tyZDA2bjEyMDA1MzJ3bzVoYm16aGx1dyJ9.LS0Fbc5bnZ5i3CIS5LMYOQ';
    
    // map instance
    let map = L.map('my-map').setView([-6.914864, 107.608238], 13);
    L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${ACCESS_TOKEN}`, {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 15,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: ACCESS_TOKEN
    }).addTo(map);

    // dom elements
    const areaListElement = document.getElementsByClassName('area-list')[0];
    const radioElements = document.getElementsByName('disaster-category-radio');
    const areaDeleteButton = document.querySelector('.area-delete-button');
    const areaListContainer = document.querySelector('.area-list-container');

    // states
    let dangerousAreaOptionFilters = [];
    let markers = [];
    let areasData = [];
    let activeArea = null;
    let activeMarker = null;
    let isEditing = false;

    const getData = (endpoint) => {
      return axios.get(endpoint, {
        headers: {
          'Content-Type': 'application/json'
        },
      })
        .then(response => response.data.data);
    }

    const postData = (endpoint, data) => {
      return axios.post(endpoint, data, {
        headers: {
          'Content-Type': 'application/json'
        }
      });
    }

    const deleteData = (endpoint) => {
      return axios.delete(endpoint, {
        headers: {
          'Content-Type': 'application/json'
        }
      });
    }

    const getCheckedRadioValue = () => {
      let radio_value = null;
      for(let i = 0; i < radioElements.length; i++){
          if(radioElements[i].checked){
              radio_value = radioElements[i].id;
          }
      }
      return radio_value;
    }

    const clearMarker = () => {
      clearActiveArea();
      for (i=0;i < markers.length;i++) {
        map.removeLayer(markers[i]);
      }
      markers = [];
    }

    const deleteMarker = area => {
      const deletedMarker = markers.filter(marker => marker._leaflet_id === area.leaflet_id && marker._leaflet_id === area.leaflet_id)[0];
        map.removeLayer(deletedMarker);
    }

    const clearRadios = () => {
      for(let i = 0; i < radioElements.length; i++){
          if(radioElements[i].checked){
              radioElements[i].checked = false;
          }
      }
    }

    const resetData = () => {
      clearMarker();
      dangerousAreaOptionFilters = [];
      markers = [];
      areasData = [];
      $('#disaster-category-filter').val(null).trigger('change');
    }

    const findMarker = (leaflet_id) => {
      return markers.filter(marker => parseInt(marker._leaflet_id) === parseInt(leaflet_id))[0];
    }

    const zoomMarkerOnClick = (e) => {
      // map.flyTo(e.target.getLatLng(), 12.5);
      clearActiveArea();
      const marker = findMarker(e.target._leaflet_id);
      const circle = L.circle(e.target.getLatLng(), {radius: 5000, color: 'red'}).addTo(map);
      map.flyTo(e.target.getLatLng(), 12.5);
      marker.openPopup();
      activeArea = circle;
    }

    const focusOnMarker = (leaflet_id) => {
      clearActiveArea();
      const marker = findMarker(leaflet_id);
      const circle = L.circle([marker._latlng.lat, marker._latlng.lng], {radius: 5000, color: 'red'}).addTo(map);
      map.flyTo(marker.getLatLng(), 12.5);
      marker.openPopup();
      activeArea = circle;
    }

    const clearActiveArea = () => {
      if(activeArea) map.removeLayer(activeArea);
    }

    const renderMarker = (data) => {
      let areaList = '';
      for(let i = 0; i < data.length; i++){
        const {latitude, longitude, category_name, id, leaflet_id} = data[i]
        const marker = L
          .marker([latitude, longitude])
          .addTo(map)
          .on('click', zoomMarkerOnClick);
        marker
          .bindPopup(`<div class="marker-popup">
                        <div class="d-flex justify-content-between">
                          <p>${category_name}</p>
                          <div class="d-flex">
                            <button class="btn btn-danger popup-area-delete-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}">
                              <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-success ml-1 popup-area-edit-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}">
                              <i class="fas fa-edit"></i>
                            </button>
                          </div>
                        </div>
                        <small>[${latitude}, ${longitude}]</small>
                      </div>`, {
            permanent: true,
            center: true
          })
        markers = [...markers, marker];
        data[i].leaflet_id = marker._leaflet_id;
        areaList += `<div class="area-list-item d-flex justify-content-start align-items-center mr-2 mr-lg-0">
                      <button class="btn btn-danger area-delete-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}" >
                        <i class="fas fa-trash"></i>
                      </button>
                      <button type="button" class="btn btn-success ml-1 area-edit-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}">
                        <i class="fas fa-edit"></i>
                      </button>
                      <p class="my-auto ml-1 d-flex flex-column">
                        <a href="#" class="category-name" data-id="${id}" data-leaflet_id="${marker._leaflet_id}">
                          ${category_name}
                        </a>
                        <small>${latitude}, ${longitude}</small>
                      </p>
                    </div>`;
      }
      areaListElement.innerHTML = areaList;
    }

    const deleteMarkerArea = (leaflet_id, id, delay = 2000) => {
      focusOnMarker(leaflet_id);
        setTimeout(async function() {
          if(confirm('are you sure want to delete the data?')){
            const response = await deleteData('api/dangerous-areas/' + id);
            const deletedData = response.data.data;
            areasData = areasData.filter(data => data.id !== deletedData.id);
            clearMarker();
            renderMarker(areasData); 
          }
        }, delay)
    }

    const renderIsEditing = () => {

    }

    const handlePopupDelete = (e) => {
      e.preventDefault();
      alert('hahaa')
      const {id, leaflet_id} = e.target.dataset;
      deleteMarkerArea(leaflet_id, id)
    }

    areaListContainer.addEventListener('click', async function(e){
      console.log(e.target)
      // category name detail
      if(e.target.classList.contains('category-name') === true){
        e.preventDefault();
        const {id, leaflet_id} = e.target.dataset;
        focusOnMarker(leaflet_id);
      }

      // area edit button
      if (e.target.classList.contains('area-edit-button') === true && isEditing === false) {
        isEditing = true;
        const {id, leaflet_id} = e.target.dataset;
        activeMarker = findMarker(leaflet_id);
        focusOnMarker(leaflet_id);
        alert('set new marker position by clicking on the map');
      }

      // area delete button
      if (e.target.classList.contains('area-delete-button') === true) {
        const {id, leaflet_id} = e.target.dataset;
        deleteMarkerArea(leaflet_id, id)
      }
    })

    map.on('click', async function(e) {
      const disasterCategoryId = getCheckedRadioValue();
      if(disasterCategoryId){
        resetData();
        const {id, lat, lng} = e.latlng;
        const response = await postData('api/dangerous-areas', {
          latitude: lat, 
          longitude: lng,
          disaster_category_id: disasterCategoryId
        });
        areasData = [response.data.data];
        renderMarker(areasData);
        focusOnMarker(areasData[0].leaflet_id)
      }

      if(isEditing){
        clearActiveArea();
        const {id, lat, lng} = e.latlng;
        activeMarker.setLatLng([lat, lng]);
        focusOnMarker(activeMarker._leaflet_id);
        isEditing = false;
      }

    } );

    map.on('popupopen', function() {  
      $('.popup-area-delete-button').click(function(e){
        const {id, leaflet_id} = e.target.dataset;
        deleteMarkerArea(leaflet_id, id, 0)
      });

      $('.popup-area-edit-button').click(function(e){
        const {id, leaflet_id} = e.target.dataset;
        activeMarker = findMarker(leaflet_id);
        isEditing = true;
        alert('set new marker position by clicking on the map');
      });
    });

    let disasterCategoryFilterData = await getData('api/disaster-categories');
    
    /*
      JQUERY
    */
    const disasterCategoryOptionData = $.map(disasterCategoryFilterData, function (obj) {
      obj.id = obj.id;
      obj.text = obj.name;
      obj.id = obj.id;
      return obj;
    });

    $('.disaster-category-filter').select2({
       placeholder: "Filter by Disaster Categories",
       data: disasterCategoryOptionData
    });

    $('.disaster-category-filter').on('select2:select', async function (e) {
      clearRadios();
      clearMarker();
      const {id, name} = e.params.data;
      dangerousAreaOptionFilters.push(id);
      const response = await postData('api/filter-areas', {
        categories: dangerousAreaOptionFilters
      });
      areasData = [...response.data.data];
      renderMarker(areasData);
    });

    $('.disaster-category-filter').on('select2:unselecting', async function (e) {  
      clearRadios();
      clearMarker();
      const {id, name} = e.params.args.data;
      dangerousAreaOptionFilters.pop(id);
      const response = await postData('api/filter-areas', {
        categories: dangerousAreaOptionFilters
      });
      areasData = [...response.data.data];
      renderMarker(areasData);
    });
  })
</script>
@endpush