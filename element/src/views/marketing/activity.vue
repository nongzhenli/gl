<template>
    <div class="app-container view-marketing-activity">
        test
    </div>
</template>

<script>
import { getMarktingNumber } from '@/api/marketing'
export default {
    data() {
        return {
        }
    },
    created() {
        getMarktingNumber({ act_id: 1 }).then(response => {
            console.log(response);
        })
    },
    mounted() {

    }
}
</script>
<style lang="less">
</style>
 