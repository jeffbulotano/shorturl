<template>
  <v-container fill-height>
    <v-layout
      wrap
      align-center
      justify-center
    >
      <v-flex md6 sm8 xs10>
        <v-card :loading="loading">
          <v-card-title class="title">Start creating short links</v-card-title>
          <v-card-text class="pb-0">
            <v-form v-model="valid" @submit.prevent="validateAndSubmit" lazy-validation ref="form">
              <v-text-field
                label="Type your original URL here"
                :rules="[v => !!v || 'This field is required.']"
                v-model="formData.long_url"
              >
                <template v-slot:append-outer>
                  <v-btn type="submit" color="success" style="margin-top: -7px;">Shorten</v-btn>
                </template>
              </v-text-field>
            </v-form>
          </v-card-text>

          <v-fade-transition>
            <v-card-text v-if="errorMessage">
              <v-card color="error" dark>
                <v-card-text>
                  <span class="title">{{ errorMessage }}</span>
                </v-card-text>
              </v-card>
            </v-card-text>
          </v-fade-transition>
          
          <v-card-text>
            <v-card outline class="mb-4" v-for="redirect in shortUrls" :key="redirect.hash">
              <v-card-text>
                <v-layout align-center>
                  <span class="subtitle-1">{{ redirect.long_url }}</span>
                  <v-spacer></v-spacer>
                  <span class="ma-4 subtitle-1">{{ currentUrl + redirect.hash }}</span>
                  <v-btn @click="copyToClipboard(currentUrl + redirect.hash)">copy</v-btn>
                </v-layout>
              </v-card-text>
            </v-card>
          </v-card-text>
        </v-card>
      </v-flex>     
    </v-layout>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  name: 'CreateShortlinkForm',
  data: () => ({
    valid: false,
    loading: false,
    currentUrl: `${window.location.protocol}//${window.location.host}/`,
    formData: {
      long_url: ''
    },
    shortUrls: [],
    errorMessage: ''
  }),
  methods: {
    validateAndSubmit() {
      if (this.$refs.form.validate()) {
        this.createShortlink()
      }
    },
    createShortlink() {
      this.loading = true
      this.errorMessage = ''

      axios.post('api/redirect_url/store', this.formData).then(({data}) => {
        if (!this.shortUrls.some(v => v.hash === data.hash)) {
          this.shortUrls.unshift(data)
        }

        // store shortUrls in localStorage for persistency
        localStorage.setItem('short_urls', JSON.stringify(this.shortUrls))

        this.loading = false
      }).catch(error => {
        console.log(error.response.data.message)
        this.errorMessage = error.response.data.message
        this.loading = false
      })
    },
    copyToClipboard(string) {
      let el = document.createElement('textarea')

      el.value = string
      el.setAttribute('readonly', '')
      el.style.position = 'absolute'
      el.style.left = '-200%'
      document.body.appendChild(el)
      el.select()
      document.execCommand('copy')
      document.body.removeChild(el)
    }
  },
  mounted() {
    this.shortUrls = JSON.parse(localStorage.getItem('short_urls')) || []
  }
}
</script>