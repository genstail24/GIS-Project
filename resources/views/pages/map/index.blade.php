@extends('layouts.templates.main')

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

  .search-container{
    position: relative;
  }

  .loading-container{
      position: absolute; 
      top: 0;
      left: 0;
      height: 100%; 
      width: 100%; 
      z-index: 9999999999; 
      background: black; 
      opacity: 0.75;
  }
   
  #search-result{
    position: absolute;
    box-sizing: border-box;
    top: 35px;
    left: 0;
    z-index: 1001;
    width: 100%;
    background: #FFF;
    list-style: none;
    /*padding: 5px 0;*/
  }

  ul#search-result li{
      padding: 5px 0;
      list-style: none;
  } 

  @media screen and (min-width:  992px){
    .area-list{
      /*flex-direction:  column !important;*/
      height: 90vh !important;
    }

    .area-list-item{
      margin-bottom: 5px;
    }

  }
</style>
@endpush

@section('title', '| Disaster Prone Area Map')

@section('content')
<div class="container-fluid main-content">
  <div class="loading-container d-flex flex-column flex-md-row ml-0 ml-md-2 justify-content-center align-items-center" id="loading-container">
      <img src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="loading">
      <p class="m-0 ml-lg-2">Loading...</p>
  </div>
  <div class="row">
      <div class="col-md-12 page-header">
          <!-- <div class="page-pretitle">Overview</div> -->
          <h2 class="page-title">Disaster Prone Area</h2>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-lg-12 ">
      <div class="form-group search-container">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search Place" aria-label="Recipient's place" aria-describedby="basic-addon2" id="search-input">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="clear-search-input">clear</button>
          </div>
        </div>
        <div class="search-result" id="search-result">
          
        </div>
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
      <div class="area-list area-list-container p-1 rounded bg-white d-flex flex-row flex-lg-column">
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
  @if(Auth::user()->is_admin)
  <div class="row mt-2">
    <div class="col-12 d-flex">
      <div class="radio-categories-container d-flex w-100">
        <div class="bg-white px-2">Add Area: </div>
        <div class="overflow-auto d-flex w-100">
          @foreach($categories as $category)
          <div class="form-check mr-3 overflow-x-auto px-2 ml-3">
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
  @endif

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

    // before ajax call
    axios.interceptors.request.use(function(config) {
      $("#loading-container").removeClass('d-none');
      $("#loading-container").addClass('d-flex');
      // showLoading();
      return config;
    }, function(error) {
      $("#loading-container").addClass('d-none');
      $("#loading-container").removeClass('d-flex');
       // hideLoading();
      return Promise.reject(error);
    });

    // after ajax call
    axios.interceptors.response.use(function(response) {
      $("#loading-container").addClass('d-none');
      $("#loading-container").removeClass('d-flex');
      // hideLoading();
      return response;
    }, function(error) {
      $("#loading-container").addClass('d-none');
      $("#loading-container").removeClass('d-flex');
       // hideLoading();
      return Promise.reject(error);
    });

    const showLoading = () => {
      document.querySelector("#loading-container").classList.add('d-none');
      document.querySelector("#loading-container").classList.remove('d-flex');
    }

    const hideLoading = () => {
      document.querySelector("#loading-container").classList.remove('d-none');
      document.querySelector("#loading-container").classList.add('d-flex');
    }
    
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

    // csrf token
    const csrfToken = document.querySelector(`meta[name="csrf-token"]`).getAttribute('content') 

    // dom elements
    const areaListElement = document.getElementsByClassName('area-list')[0];
    const radioElements = document.getElementsByName('disaster-category-radio');
    const areaDeleteButton = document.querySelector('.area-delete-button');
    const areaListContainer = document.querySelector('.area-list-container');
    const searchResultElement = document.querySelector('#search-result');
    const searchInputElement = document.querySelector('#search-input');

    const radius = 10000;
    const zoom = 11.5;

    // states
    let dangerousAreaOptionFilters = [];
    let markers = [];
    let areasData = [];
    let searchLocationFilter = null;
    let activeArea = null;
    let activeMarker = null;
    let isEditing = false;
    let editedMarker = {
      leaflet_id: null,
      id: null
    };
    let typingInterval;
    let searchArea = null;

    const getData = (endpoint) => {
      return axios.get(endpoint, {
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
      })
        .then(response => response.data.data);
    }

    document.querySelector('#search-input').addEventListener('input', function(e){
      clearInterval(typingInterval)
      const {value} = e.target;
      typingInterval = setInterval(async () => {
        // if(value == '') searchLocationFilter = '';
        clearInterval(typingInterval)
        const response = await searchLocation(value)
        const placeSugesstion = response.data.map(place => `
            <li class="sugestion" data-id="${place.place_id}" data-latitude="${place.lat}" data-longitude="${place.lon}" data-value="${place.display_name}">${place.display_name}</li>
          `);
        $('#search-result').html(placeSugesstion)

      }, 1000)
    })

    function setLocation(latitude, longitude){
      alert('hahaa')
    }

    const searchLocation = (keyword) => {
      return axios.get(`https://nominatim.openstreetmap.org/search?q=${keyword}&format=json`);
    }

    searchResultElement.addEventListener('click', async function(e){
      if(e.target.classList.contains('sugestion')){
        if(searchArea) map.removeLayer(searchArea)
        console.log(e.target.dataset)
        const {id, latitude, longitude, value} = e.target.dataset;
        searchResultElement.innerHTML = '';
        searchInputElement.value = value;
        //search to db
        searchLocationFilter = {latitude, longitude}
        searchArea = L
          .circle([latitude, longitude], {radius: radius, color: 'blue'})
          .addTo(map)
          .bindPopup(`<h3 class="text-center">${value}</h3> <br> <h5 class="text-center">Disaster prone area of this blue area in radius of 10km</h3>`);
        map.flyTo(searchArea.getLatLng(), zoom); 
        await getAreas();
        if(areasData.length < 1) {
          alert('Data is not found!')
        }
      }
    })

    $('#clear-search-input').on('click', function(){
      searchInputElement.value = '';
      searchLocationFilter = '';
      map.removeLayer(searchArea);
      getAreas();
    });

    const postData = (endpoint, data) => {
      return axios.post(endpoint, data, {
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        }
      });
    }

    const deleteData = (endpoint) => {
      return axios.delete(endpoint, {
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        }
      });
    }

    const updateMarker = async (id, data) => {
      return axios.put('dangerous-areas/' + id, data, {
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
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

    const clearMarkers = () => {
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
      clearMarkers();
      removeMultiSelectValues()
      searchLocationFilter = '';
      markers = [];
      areasData = [];
      if(searchArea) map.removeLayer(searchArea);
      searchInputElement.value = '';
    }

    const removeMultiSelectValues = () => {
      dangerousAreaOptionFilters = [];
      $('#disaster-category-filter').val(null).trigger('change');
    }
    const findMarker = (leaflet_id) => {
      return markers.filter(marker => parseInt(marker._leaflet_id) === parseInt(leaflet_id))[0];
    }

    const findArea = (leaflet_id) => {
      return areasData.filter(area => parseInt(area.leaflet_id) === parseInt(leaflet_id))[0];
    }

    const zoomMarkerOnClick = (e) => { 
      clearActiveArea();
      const circle = L.circle(e.target.getLatLng(), {radius: radius, color: 'red'}).addTo(map);
      map.flyTo(e.target.getLatLng(), zoom);
      activeArea = circle;
    }

    const focusOnMarker = (leaflet_id) => {
      clearActiveArea();
      const marker = findMarker(leaflet_id);
      const circle = L.circle(marker.getLatLng(), {radius: radius, color: 'red'}).addTo(map);
      map.flyTo(marker.getLatLng(), zoom);
      marker.openPopup();
      activeArea = circle;
    }

    const clearActiveArea = (area = null) => {
      if(activeArea) map.removeLayer(activeArea);
      if(activeMarker) map.removeLayer(activeMarker);
    }

    const renderMarker = (params = []) => {
      const data = params.length ? params : areasData;
      clearMarkers();
      let areaList = '';
      for(let i = 0; i < data.length; i++){
        const {latitude, longitude, category_name, id, leaflet_id} = data[i]
        const marker = L
          .marker([latitude, longitude])
          .addTo(map)
          .on('click', zoomMarkerOnClick)
        marker.bindPopup(`<div class="marker-popup">
                        <div class="d-flex justify-content-between">
                          <p>${category_name}</p>
                          @if(Auth::user()->is_admin)
                          <div class="d-flex">
                            <button class="btn btn-danger popup-area-delete-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}">
                              <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-success ml-1 popup-area-edit-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}">
                              <i class="fas fa-edit"></i>
                            </button>
                          </div>
                          @endif
                        </div>
                        <small>[${latitude}, ${longitude}]</small>
                      </div>`);

        markers = [...markers, marker];
        data[i].leaflet_id = marker._leaflet_id;
        areaList += `<div class="area-list-item d-flex justify-content-start align-items-center mr-2 mr-lg-0">
                      <!--<button class="btn btn-danger area-delete-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}" >
                        <i class="fas fa-trash"></i>
                      </button>
                      <button type="button" class="btn btn-success ml-1 area-edit-button" data-id="${id}" data-latitude="${latitude}" data-longitude="${longitude}" data-leaflet_id="${marker._leaflet_id}">
                        <i class="fas fa-edit"></i>
                      </button> -->
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

    const deleteMarkerArea = (leaflet_id, id, delay = 1000) => {
      focusOnMarker(leaflet_id);
      setTimeout(async function() {
        if(confirm('are you sure want to delete the data?')){
          const response = await deleteData('dangerous-areas/' + id);
          getAreas()
        }else map.closePopup();;

      }, delay)
    }

    const getAreas = async () => {
      clearRadios();
      clearMarkers();
      $('#mySelect2').val(dangerousAreaOptionFilters).trigger('change');
      const response = await postData('filter-areas', {
        categories: dangerousAreaOptionFilters,
        search: searchLocationFilter
      });
      areasData = [...response.data.data];
      renderMarker(areasData);
    }

    const handlePopupDelete = (e) => {
      e.preventDefault();
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
        editedMarker.id = id;
        editedMarker.leaflet_id = leaflet_id
        alert('set new marker position by clicking on the map');
      }

      // area delete button
      if (e.target.classList.contains('area-delete-button') === true) {
        const {id, leaflet_id} = e.target.dataset;
        deleteMarkerArea(leaflet_id, id)
      }
    })

    map.on('click', async function(e) {
      clearActiveArea();
      const disasterCategoryId = getCheckedRadioValue();
      const {id, lat, lng} = e.latlng;
      if(disasterCategoryId){
        resetData();
        const response = await postData('dangerous-areas', {
          latitude: lat, 
          longitude: lng,
          disaster_category_id: disasterCategoryId
        });
        areasData = [response.data.data];
        renderMarker();
        focusOnMarker(areasData[0].leaflet_id);
      }

      if(isEditing === true && editedMarker.id){
        if(searchArea) map.removeLayer(searchArea);
        const response = await updateMarker(editedMarker.id, {
          latitude: lat,
          longitude: lng
        });
        resetData();
        editedMarker.id = null;
        editedMarker.leaflet_id = null;
        isEditing = false;
        areasData = [response.data.data];
        renderMarker();
        focusOnMarker(areasData[0].leaflet_id);
      }
    } );

    map.on('popupopen', function() {  
      $('.popup-area-delete-button').click(function(e){ 
        const {id, leaflet_id} = e.target.dataset;
        deleteMarkerArea(leaflet_id, id, 0)
      });

      $('.popup-area-edit-button').click(function(e){
        const {id, leaflet_id} = e.target.dataset;
        const editedArea = findArea(leaflet_id);
        if(confirm('set new marker position by clicking on the map')) {
          if(searchArea) map.removeLayer(searchArea);
          editedMarker.id = id;
          editedMarker.leaflet_id= leaflet_id;
          renderMarker([editedArea]);
          isEditing = true;
        }else{
          map.closePopup();
        }
      });
    });

    let disasterCategoryFilterData = await getData('get-disaster-categories');

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
      const {id, name} = e.params.data;
      dangerousAreaOptionFilters = [...dangerousAreaOptionFilters, id];
      getAreas();
    });

    $('.disaster-category-filter').on('select2:unselecting', async function (e) {  
      const {id, name} = e.params.args.data;
      const newData = dangerousAreaOptionFilters.filter(item => parseInt(id) !== parseInt(item));
      dangerousAreaOptionFilters = [...newData];
      getAreas();
    });
  })
</script>
@endpush