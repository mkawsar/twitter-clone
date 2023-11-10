export default {
    notify($this, title, text) {
        let template = '<span><b>' + title + '</b> - ' + text + '</span>';
        this.notifyText($this, 'top', 'right', template, 'ti-info-alt', 'success');
    },

    error($this, title, text) {
        let template = '<span><b>' + title + '</b> - ' + text + '</span>';
        this.notifyText($this, 'top', 'right', template, 'ti-info-alt', 'danger');
    },

    notifyValidationErrors($this, notifications) {
        if (typeof notifications === 'string') {
            let template = '<span><b>' + title + '</b> - ' + text + '</span>';
            this.notifyText($this, 'top', 'right', template, 'ti-info-alt', 'danger');
        } else if (notifications.constructor === Array) {
            let template = '<ul style="list-style-type: disc">';
            for (let key in notifications) {
                if (notifications.hasOwnProperty(key)) {
                    template += '<li>' + notifications[key] + '</li>';
                }
            }
            template += '</ul>';
            this.notifyText($this, 'top', 'right', template, 'ti-info-alt', 'danger');
        }

    },

    notifyError($this, notifications) {
        if (notifications.hasOwnProperty('error')) {
            if (typeof notifications.error === 'string') {
                let template = '<span><b>Oops!</b> - ' + notifications.error + '</span>';
                this.notifyText($this, 'top', 'right', template, 'ti-info-alt', 'danger');
            } else if (typeof notifications.error === 'object') {
                let template = '<ul>';
                for (let key in notifications.message) {
                    if (notifications.error.hasOwnProperty(key)) {
                        template += '<li>' + notifications.error[key][0] + '</li>';
                    }
                }
                template += '</ul>';
                this.notifyText($this, 'top', 'right', template, 'ti-info-alt', 'danger');
            }
        }
    },

    notifyText($this, verticalAlign, horizontalAlign, template, icon, type) {
        $this.$notify(
            {
                component: {
                    template: template
                },
                icon: icon,
                horizontalAlign: horizontalAlign,
                verticalAlign: verticalAlign,
                type: type
            })
    }
}
