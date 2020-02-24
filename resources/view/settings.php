
<template id="settingsPage">
    <div class="wrap">
        <h2 class="mb-5">
           Settings
        </h2>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true"> Basic </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="Billing-tab" data-toggle="tab" href="#Billing" role="tab" aria-controls="Billing"
                   aria-selected="true"> Billing Info </a>
            </li>


        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <form v-on:submit.prevent="updateSetting">
                    <div class="setting-box">

                        <div class="form-group row">
                            <h5 class="col-sm-2"></h5>
                            <h5 class="mt-5 col-sm-10"> General Setting</h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right"> Licence Key </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="settings.license_key">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right"> API Key </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="settings.api_key">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="mt-1 col-sm-10">
                                <button type="submit" class="btn btn-primary"> Save</button>
                            </div>

                        </div>


                    </div>

                </form>
            </div>



           <div class="tab-pane " id="Billing" role="tabpanel" aria-labelledby="Billing-tab">

           </div>
        </div>


    </div>
</template>