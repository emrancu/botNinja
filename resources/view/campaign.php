<!--<div class="wrap">-->
<!--    <script src="http://wpapi.chatleads.io/+12057729908/call.js"></script>-->
<!---->
<!--    <h2>Test Form Submission </h2>-->
<!---->
<!--<form action="#" id="botninja" >-->
<!--    <label for="fname">First name:</label><br>-->
<!--    <input type="text" id="fname" name="fname" value="John"><br>-->
<!--    <label for="lname">Last name:</label><br>-->
<!--    <input type="text" id="lname" name="lname" value="Doe"><br><br>-->
<!--    <input type="submit" value="Submit for test">-->
<!--</form>-->
<!---->
<!---->
<!--<script>-->
<!---->
<!--    window.addEventListener('load', function() {-->
<!--        BotNinjaCall("botninja");-->
<!--    });-->
<!---->
<!--    document.getElementById('botninja').addEventListener("submit", function(e){-->
<!--        e.preventDefault();-->
<!--        -->
<!--    })-->
<!--</script>-->
<!--</div>-->

<template id="dashboardCampaign">
    <div class="wrap">
        <h2 class="mb-5"> Campaigns
            <button class="btn btn-primary float-right" v-on:click="createCampaignForm()"> Create Campaign</button>
        </h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Friendly Name</th>
                <th> Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(campaign, i) in $store.state.campaigns">
                <td>{{i+1}}</td>
                <td>{{campaign.name}}</td>
                <td>{{campaign.phone_number}}</td>
                <td>{{campaign.friendly_name}}</td>
                <td>
                    <button class="btn btn-sm btn-primary" v-on:click="goToDetails(campaign.phone_number)">Details
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>



<template id="dashboardCampaignDetails">
    <div class="wrap">

        <h2 class="mb-5">
            <button class="btn btn-primary mr-5  btn-sm" v-on:click="backToCampaign()"> Back</button>
            Campaign Details
        </h2>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true"> Details</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                   aria-controls="contact" aria-selected="false">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="phoneNumber-tab" data-toggle="tab" href="#phoneNumber" role="tab"
                   aria-controls="contact" aria-selected="false">Notification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Forwarding-tab" data-toggle="tab" href="#Forwarding" role="tab"
                   aria-controls="contact" aria-selected="false">Forwarding</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="callSetting-tab" data-toggle="tab" href="#callSetting" role="tab"
                   aria-controls="contact" aria-selected="false">Call Setting</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="FormSubmission-tab" data-toggle="tab" href="#FormSubmission" role="tab"
                   aria-controls="contact" aria-selected="false"> Form Submission Call </a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-bordered mt-5">

                    <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{campaign.name}}</td>
                    </tr>
                    <tr>
                        <td> Phone Number</td>
                        <td>{{campaign.phone_number}}</td>
                    </tr>
                    <tr>
                        <td> Country Code</td>
                        <td>{{campaign.code}}</td>
                    </tr>
                    <tr>
                        <td> Number Type</td>
                        <td>{{campaign.type}}</td>
                    </tr>
                    <tr>
                        <td> Capabilities</td>
                        <td>{{campaign.capabilities}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <form v-on:submit.prevent="updateData">
                    <div class="setting-box">

                        <div class="form-group row">
                            <h5 class="col-sm-2"></h5>
                            <h5 class="mt-5 col-sm-10"> General Setting</h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right"> Campaign Title </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right"> Enable </label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.status"
                                           id="CampaignYes" value="enabled">
                                    <label class="form-check-label" for="CampaignYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.status"
                                           id="CampaignNo" value="disable">
                                    <label class="form-check-label" for="CampaignNo">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">Phone Can Ring</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.ring_time"
                                           name="ring_time" id="CampaignRing24" value="any">
                                    <label class="form-check-label" for="CampaignRing24">24/7</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.ring_time"
                                           name="ring_time" id="CampaignRingRange" value="range">
                                    <label class="form-check-label" for="CampaignRingRange">Custom Range</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row" v-if="campaign.ring_time == 'range'">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right">Start/End Time</label>
                            <div class="col-sm-10 row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control-plaintext" v-model="campaign.start_time"
                                           placeholder="Start Time">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control-plaintext" v-model="campaign.end_time"
                                           placeholder="End Time">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Block Lists</label>
                            <div class="col-sm-10  ">
                                <input type="text" class="form-control-plaintext" v-model="campaign.block_lists"
                                       placeholder="phone number with coma">
                            </div>
                        </div>
                        <div class="form-group row">
                            <h5 class="col-sm-2"></h5>
                            <h5 class="mt-1 col-sm-10"> Billing Setting</h5>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label text-right"> Billing Type </label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.billing_type"
                                           name="perCallRate" id="perCallRate" value="call">
                                    <label class="form-check-label" for="perCallRate">Per Call</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.billing_type"
                                           name="perCallRate" id="flatCallRate" value="flat">
                                    <label class="form-check-label" for="flatCallRate">Flat Rate</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Cost Per Call </label>
                            <div class="col-sm-10  ">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                    </div>
                                    <input type="text" class="form-control" v-model="campaign.call_cost"
                                           placeholder=" Cost Per Call">
                                </div>

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

            <div class="tab-pane fade" id="phoneNumber" role="tabpanel" aria-labelledby="phoneNumber-tab">
                <form v-on:submit.prevent="updateData">
                    <div class="setting-box">
                        <div class="form-group row mt-5">
                            <label class="col-sm-2 col-form-label text-right"> Email Notification </label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.email_notification"
                                           id="notificationYes" value="enabled">
                                    <label class="form-check-label" for="notificationYes">Enabled</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.email_notification"
                                           id="notificationNo" value="disable">
                                    <label class="form-check-label" for="notificationNo">Disabled</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row" v-if="campaign.email_notification == 'enabled'">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Email Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.notification_email"
                                       placeholder="Email Address">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right"> Notification Triggered when </label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.notification_fire"
                                           id="notification_fireStart" value="start">
                                    <label class="form-check-label" for="notification_fireStart">Completed Call</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="campaign.notification_fire"
                                           id="notification_fireEnd" value="end">
                                    <label class="form-check-label" for="notification_fireEnd">New Voicemail</label>
                                </div>
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

            <div class="tab-pane fade" id="Forwarding" role="tabpanel" aria-labelledby="Forwarding-tab">
                <form v-on:submit.prevent="updateData">
                    <div class="Forwarding-box">


                        <div class="form-group row mt-5">
                            <label class="col-sm-2 col-form-label text-right"> Forwarding Method</label>
                            <div class="col-sm-10 ">

                                <div class="form-check  ">
                                    <input class="form-check-input" type="radio" name="forwardMethod"
                                           v-model="campaign.forward_method"
                                           id="singleNumber" value="single" checked>
                                    <label class="form-check-label" for="singleNumber">
                                        Single Number
                                    </label>
                                </div>

                                <div class="form-check  ">
                                    <input class="form-check-input" type="radio" name="forwardMethod"
                                           v-model="campaign.forward_method"
                                           id="multipleNumber" value="multiple">
                                    <label class="form-check-label" for="multipleNumber">
                                        Multiple Number
                                    </label>
                                </div>

                            </div>

                        </div>


                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Forwarding
                                Numbers </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.forwarding_numbers"
                                       placeholder="Forwarding Numbers">

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

            <div class="tab-pane fade" id="callSetting" role="tabpanel" aria-labelledby="callSetting-tab">
                <form v-on:submit.prevent="updateData">
                    <div class=" ">

                        <div class="form-group row mt-5">
                            <label class="col-sm-2 col-form-label text-right"> Call Record </label>
                            <div class="col-sm-10 ">

                                <div class="form-check   form-check-inline">
                                    <input class="form-check-input" type="radio" name="callRecord"
                                           v-model="campaign.record"
                                           id="callRecordEnable" value="enable" checked>
                                    <label class="form-check-label" for="callRecordEnable">
                                        Enabled
                                    </label>
                                </div>

                                <div class="form-check  form-check-inline ">
                                    <input class="form-check-input" type="radio" name="callRecord"
                                           v-model="campaign.record"
                                           id="callRecordDisable" value="disable">
                                    <label class="form-check-label" for="callRecordDisable">
                                        Disabled
                                    </label>
                                </div>

                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right"> Whisper Feature </label>
                            <div class="col-sm-10 ">

                                <div class="form-check   form-check-inline">
                                    <input class="form-check-input" type="radio" name="callWhisper"
                                           v-model="campaign.whisper"
                                           id="callWhisperEnable" value="enabled"  >
                                    <label class="form-check-label" for="callWhisperEnable">
                                        Enabled
                                    </label>
                                </div>

                                <div class="form-check   form-check-inline">
                                    <input class="form-check-input" type="radio" name="callWhisper"
                                           v-model="campaign.whisper"
                                           id="callWhisperDisable" value="disable">
                                    <label class="form-check-label" for="callWhisperDisable">
                                        Disabled
                                    </label>
                                </div>

                            </div>

                        </div>


                        <div class="form-group row" v-if="campaign.whisper == 'enabled'">
                            <label class="col-sm-2 col-form-label text-right"> Whisper Type </label>
                            <div class="col-sm-10 ">
                                <div class="form-check   form-check-inline">
                                    <input class="form-check-input" type="radio" name="whisper_type"
                                           v-model="campaign.whisper_type"
                                           id="whisper_typeText" value="text" checked>
                                    <label class="form-check-label" for="whisper_typeText">
                                        Text to Speech
                                    </label>
                                </div>

                                <div class="form-check   form-check-inline">
                                    <input class="form-check-input" type="radio" name="whisper_type"
                                           v-model="campaign.whisper_type"
                                           id="whisper_typeAudio" value="audio">
                                    <label class="form-check-label" for="whisper_typeAudio">
                                        Audio File
                                    </label>
                                </div>

                            </div>

                        </div>

                        <div class="form-group row " v-if="campaign.whisper_type == 'text'">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Whisper Text</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.whisper_text"
                                       placeholder="Whisper Text">
                            </div>
                        </div>

                        <div class="form-group row" v-if="campaign.whisper_type == 'audio'">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Whisper Audio
                                Url</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.whisper_audio"
                                       placeholder="Whisper Audio Url">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right"> Voice Mail Type </label>
                            <div class="col-sm-10 ">

                                <div class="form-check   form-check-inline">
                                    <input class="form-check-input" type="radio" name="voicemail_type"
                                           v-model="campaign.voicemail_type"
                                           id="voicemailText" value="text" checked>
                                    <label class="form-check-label" for="voicemailText">
                                        Text to Speech
                                    </label>
                                </div>

                                <div class="form-check   form-check-inline">
                                    <input class="form-check-input" type="radio" name="voicemail_type"
                                           v-model="campaign.voicemail_type"
                                           id="voicemailAudio" value="audio">
                                    <label class="form-check-label" for="voicemailAudio">
                                        Audio File
                                    </label>
                                </div>

                            </div>

                        </div>

                        <div class="form-group row " v-if="campaign.voicemail_type =='text'">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Voice-mail Text</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.voicemail_text"
                                       placeholder="Voice-mail Text">
                            </div>
                        </div>

                        <div class="form-group row" v-if="campaign.voicemail_type =='audio'">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right"> Voice-mail Audio
                                Url</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.voicemail_audio"
                                       placeholder="Voice-mail Audio Url">
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

            <div class="tab-pane fade" id="FormSubmission" role="tabpanel" aria-labelledby="FormSubmission-tab">
                <form v-on:submit.prevent="updateData">
                    <div class="Forwarding-box">


                        <div class="form-group row mt-5">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right">
                                Number to Dial </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.form_call_number" placeholder="Dial Number">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right">
                                Message to Play </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" v-model="campaign.form_call_text"
                                       placeholder="Message to Play">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label text-right">
                                Script </label>
                            <div class="col-sm-10">
                                <p>Place this before end of your </head> tag</p>
                                <pre class="bg-secondary text-light"> &lt;script src="http://wpapi.chatleads.io/{{campaign.phone_number}}/call.js"&gt;&lt;/script&gt; </pre>
                                <p>Code To Integrate With Your Forms (Place this before end of your &lt;/body&gt; tag)</p>
<pre class="bg-secondary text-light">
    &lt;script>
    window.addEventListener('load', function() {
        BotNinjaCall("your form ID");
    });
   &lt;/script&gt;
</pre>

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

        </div>

    </div>
</template>


<template id="CreateCampaign">
    <div class="wrap">
        <h2 class="mb-5">
            <button class="btn btn-primary mr-5  btn-sm" v-on:click="backToCampaign()"> Back</button>
            Create Campaign
        </h2>

        <form class="row" v-on:submit.prevent="getPhoneNumber">
            <div class="form-group col-sm-4">
                <label>Select Country</label>
                <select class="form-control" v-model="campaign.countryCode">
                    <option value="">Select Country</option>
                    <option v-for="country in countries" :value="country.short_name">{{country.name}}</option>
                </select>
            </div>

            <div class="form-group col-sm-4">
                <label> Select Number Types </label>
                <select class="form-control" v-model="campaign.numberType">
                    <option v-for="type in numberTypes" :value="type.id"> {{type.name}}</option>
                </select>
            </div>
            <div class="form-group mt-4">
                <button class="mt-2 btn btn-primary float-right"> Get Phone Number</button>
            </div>
        </form>

        <div class="">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Phone NUmber</th>
                    <th>Friendly Name</th>
                    <th>Country Code</th>
                    <th>Capabilities</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(number, i) in phoneNumbers" :key="i">
                    <td>{{i+1}}</td>
                    <td>{{number.phoneNumber}}</td>
                    <td>{{number.friendlyName}}</td>
                    <td>{{number.countryCode}}</td>
                    <td>
                        SMS: {{ number.capabilities.SMS }}, Voice:
                        {{ number.capabilities.voice }} , MMS:
                        {{ number.capabilities.MMS }}
                    </td>
                    <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createCampaignModal"
                                @click="campaign.numberDetails = number"> Create
                        </button>
                    </td>
                </tr>
                </tbody>

            </table>
        </div>

        <div class="modal fade" id="createCampaignModal" tabindex="-1" role="dialog"
             aria-labelledby="createCampaignModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> Create Campaign </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>Number : {{campaign.numberDetails.phoneNumber}} <span class="text-primary">({{campaign.numberDetails.friendlyName}})</span>
                        </h3>
                        <div class="form-group">
                            <label> Campaign Title</label>
                            <input type="text" class="form-control" v-model="campaign.title">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createCampaign"> Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

