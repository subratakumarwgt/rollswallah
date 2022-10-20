self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        console.log("notifications aren't supported or permission not granted!")//
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        console.log(msg,"from SW")
        
        e.waitUntil(self.registration.showNotification("New Order", {
            body: "Hello this is body",
            icon: "",
            actions: [{action: "get",title:"titlehere"}]
        }));

        // console.log(self.registration.showNotification("New Order", {
        //     body: "Hello this is body",
        //     icon: "",
        //     actions: [{action: "get",title:"titlehere"}]
        // }),"e")
    }
});