<template>
    <div>
        <div class="row">
            <div class="col">
                <h1>Contattaci</h1>
                <form action="api/contact" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" v-model="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" v-model="email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Messaggio</label>
                        <textarea class="form-control" id="message" name="message" v-model="message"></textarea>
                    </div>
                    <button class="btn btn-primary">Invia</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PageContact',
}
</script>

<style lang="scss" scoped>
</style>