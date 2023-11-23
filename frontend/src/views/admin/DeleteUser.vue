<template>
  <v-row justify="center">
    <v-card>
      <v-card-title>Selecione qual email deseja excluir</v-card-title>
      <v-divider />
      <v-card-text style="height: 300px;">
        <v-radio-group
          v-model="email"
          column
        >
          <v-radio
            v-for="(email, index) in emails"
            :key="index"
            :label="email"
            :value="email"
          />
        </v-radio-group>
      </v-card-text>
      <v-divider />
      <v-card-actions>
        <v-btn
          color="blue-darken-1"
          variant="text"
          @click="emits('close');"
        >
          Close
        </v-btn>
        <v-btn
          color="blue-darken-1"
          variant="text"
          @click="deleteUser"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-row>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import Admin from "@/api/Admin";

const emits = defineEmits(["close"]);

const emails = ref([]);
const email = ref("");

//allCommonUser

onMounted( async () => { 
    loading.value = !loading.value;
    await Admin.allCommonUser().then((res => {
        loading.value = !loading.value;
        console.log(res);

        res.data.users.forEach((el) => {
            console.log(el);
            emails.value.push(el.email);

        });

        console.log("emial: " + emails.value);
    })).catch((err => {
        console.error(err);
        loading.value = !loading.value;
    }));
});

const loading = ref(false);


const deleteUser = ( async () => {
    loading.value = !loading.value;

    await Admin.deleteUser(email.value).then((res => {
        loading.value = !loading.value;
        emits("close");
        console.log(res);
    })).catch((err => {
        console.error(err);
        loading.value = !loading.value;
    }));

});
</script>