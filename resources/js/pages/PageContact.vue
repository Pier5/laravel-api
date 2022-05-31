<template>
    <div>
        <div class="row">
            <div class="col">
                <h1>Contattaci</h1>
                <div v-if="statusMessage" class="alert alert-success" role="alert">
                    {{ statusMessage }}
                </div>
                <div v-if="generalErrorMessage" class="alert alert-danger" role="alert">
                    {{ generalErrorMessage }}
                </div>
                <form @submit.prevent="sendMessage" action="api/contact" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" v-model="name">
                    </div>
                    <div v-for="(error, index) in errors.name" :key="index + error" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" v-model="email">
                    </div>
                    <div v-for="(error, index) in errors.email" :key="index + error" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Messaggio</label>
                        <textarea class="form-control" id="message" name="message" v-model="message"></textarea>
                    </div>
                    <div v-for="(error, index) in errors.message" :key="index + error" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>

                    <button class="btn btn-primary" :disabled="sending">{{ sending ? 'Attendi ...' : 'Invia' }}</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PageContact',
        data() {
        return {
            apiUrl: "/api/contact",
            name: '',
            email: '',
            message: '',
            statusMessage: '',
            errors: {},
            generalErrorMessage: '',
            sending: false
        }
    },
    methods: {
        sendMessage() {
            this.sending = true;
            this.statusMessage = '';
            this.generalErrorMessage = '';
            this.errors = {};
            Axios.post(this.apiUrl, {
                name: this.name,
                email: this.email,
                message: this.message
            })
            .then(res => {
                if (res.data.success) {
                    this.statusMessage = res.data.statusMessage;
                } else {
                    this.errors = res.data.errors;
                }
            })
            .catch(error => this.generalErrorMessage = 'C\'è stato un errore imprevisto. Riprova')
            .finally(res => this.sending = false);
        }
    }
}
</script>

<style lang="scss" scoped>
</style>