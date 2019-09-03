<template>
  <v-container fill-height>
    <v-layout
      text-center
      wrap
      align-center
      justify-center
    >
      <v-flex md3 sm4 xs10>
        <v-card>
          <v-card-title>Start creating short links</v-card-title>
          <v-card-text>
            <v-form v-model="valid" @submit.prevent="createShortlink">
              <v-text-field
                label="Type your original URL here"
                :rules="[v => !!v || 'This field is required.']"
                v-model="formData.long_url"
              >
                <template v-slot:append-outer>
                  <v-btn type="submit" small>Shorten</v-btn>
                </template>
              </v-text-field>
            </v-form>
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
    formData: {
      long_url: ''
    }
  }),
  methods: {
    createShortlink() {
      axios.post('http://shorturl.test/api/redirect_url/store', this.formData)
    }
  }
}
</script>
