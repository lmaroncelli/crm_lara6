<template>
    <div class="input-group">
    <input id="password" :type="p_type" placeholder="Password" class="form-control" name="password" required autocomplete="current-password">
    <span class="input-group-append">
        <button class="btn btn-primary" type="button" @click="togglePassword()">
        <i :class="{ 'fa fa-eye': !visibility, 'fa fa-eye-slash': visibility }"></i>
        </button>
    </span>
    </div>
</template>

<script>
    export default {
    

        data() {

            return {
                visibility: false ,
                p_type: 'password' 
            }
        },

        methods: {
            
            togglePassword() {
                
                this.visibility == false ? this.visibility = true : this.visibility = false;
                this.visibility == false ? this.p_type = 'password' : this.p_type = 'text';
                
            }

        },
    }
</script>
