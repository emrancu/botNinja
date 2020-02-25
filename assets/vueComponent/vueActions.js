const dashboard = Vue.extend({
    data: function () {
        return {
            name: '',
        }
    },
    methods: {},
    template: '#dashboardContent',

});


const Campaign = Vue.extend({
    data: function () {
        return {
            campaigns: []
        };
    },
    mounted() {
        if(!this.$store.state.campaigns.length){
            this.getCampaign() ;
        }
    },
    methods: {
        createCampaignForm: function () {
            router.push('CreateCampaign');
        },
        getCampaign: async function(){
            this.$store.state.campaigns = await getRequest('Campaigns', false, true);
        },
        goToDetails: function(phoneNumber){
            router.push({ name: 'CampaignDetails', params: { phoneNumber: phoneNumber }} );
        }
    },
    template: '#dashboardCampaign'
});


const CampaignDetails = Vue.extend({
    data: function () {
        return {
            single_campaign: {}
        };
    },
    mounted() {

        if(!this.$store.state.campaigns.length){
            this.getCampaign() ;
        }
    },
    computed: {
        campaign() {
            let data = this.$store.state.campaigns.filter(item=>{
                return this.$route.params.phoneNumber == item.phone_number
            })
            return data.length ? data[0] : {} ;
        }
    },
    methods: {
        updateData: async function () {
            let campaign = await postRequest('UpdateCampaign',this.campaign,true);
            if(campaign){
                webToast.Success({
                    status:'Success !',
                    message:'Campaign Updated Successfully'
                });
               // await this.getCampaign();
            }
        },
        getCampaign: async function(){
            this.$store.state.campaigns = await getRequest('Campaigns', false, true);
        },
        getCampaignDetails: async function(){
            this.campaign = await getRequest('CampaignDetails/'+ (this.$route.params.phoneNumber).substr(1), false, true);
        },
        goToDetails: function(phoneNumber){
            router.push({ name: 'CampaignDetails', params: { phoneNumber: phoneNumber }} );
        },
        backToCampaign: function () {
            router.push({ name: 'Campaign'} );
        },
    },
    template: '#dashboardCampaignDetails'
});


const CreateCampaign = Vue.extend({
    data: function () {
        return {
            countries: [],
            numberTypes: [
                {id: "local", name: "Local"},
                {id: "toll free", name: "Toll Free"},
                {id: "mobile", name: "Mobile"}
            ],
            phoneNumbers: [],
            campaign: {title: '', countryCode: '', numberType: '', numberDetails: {}}
        };
    },
    mounted() {
        this.getCountry();
    },
    methods: {
        backToCampaign: function () {
            router.push('Campaign');
        },
        createCampaign: async function () {

            let campaign = await postRequest('createCampaign',this.campaign,true);
            if(campaign){
                webToast.Success({
                    status:'Success !',
                    message:'Campaign Created Successfully'
                })
                this.campaign = {title: '', countryCode: '', numberType: '', numberDetails: {}} ;
                jQuery("#createCampaignModal").modal('hide')
            }
        },
        getPhoneNumber: async function () {
            if (!this.campaign.numberType || !this.campaign.countryCode) {
                alert('Check required field');
                return false;
            }
            let url = 'https://staging.chatleads.io/api/twilio/phone-number/' + this.campaign.numberType + '/' + this.campaign.countryCode;
            this.phoneNumbers = await getRequest(url,true);

        },
        getCountry: async function () {
            this.countries = await getRequest('https://staging.chatleads.io/api/get-countries');
        }
    },
    template: '#CreateCampaign'
});


const Report = Vue.component('vueComponent', {
    data: function () {
        return {
            name: '',
        }
    },
    methods: {},
    template: '#dashboardReport',
});

const settings = Vue.component('vueComponent', {
    data: function () {
        return {
            name: '',
            settings: {},
        }
    },
    mounted(){
      this.getSettings() ;
    },
    methods: {
        updateSetting: async function(){
            let campaign = await postRequest('saveSetting',this.settings,true);
            if(campaign){
                webToast.Success({
                    status:'Success !',
                    message:'Updated Successfully'
                }) ;
            }
        },
        getSettings: async function(){
            let setting =  await getRequest('setting' , false, true, true);
            if(setting){
                this.settings = setting ;
            }else{
                this.settings = {} ;
            }
        },
    },
    template: '#settingsPage',
});


const router = new VueRouter({
    scrollBehavior(to, from, savedPosition) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve({x: 0, y: 0})
            }, 1500)
        })
    },
    routes: [
        {
            name: 'Home',
            path: '/',
            component: dashboard
        },
        {
            name: 'Dashboard',
            path: '/Dashboard',
            component: dashboard,
            meta: {depth: 1}
        },
        {
            name: 'Campaign',
            path: '/Campaign',
            component: Campaign
        },
        {
            name: 'CreateCampaign',
            path: '/CreateCampaign',
            component: CreateCampaign
        },
        {
            name: 'CampaignDetails',
            path: '/CampaignDetails/:phoneNumber',
            component: CampaignDetails
        },
        {
            name: 'Report',
            path: '/Report',
            component: Report
        },
        {
            name: 'Settings',
            path: '/Settings',
            component: settings
        }
    ]
});
