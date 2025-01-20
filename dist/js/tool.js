/*! For license information please see tool.js.LICENSE.txt */
(()=>{"use strict";var t,e={551:(t,e,r)=>{const o=Vue;var n={class:"tw-grid tw-grid-cols-2 tw-gap-4 p-4"},a={class:""},i={class:"tw-my-2 tw-text-xl"},c={class:"tw-mb-3"},l={class:"tw-bg-gray-100 tw-text-gray-800 tw-text-xs tw-font-semibold tw-mr-2 tw-px-2.5 tw-py-0.5 tw-rounded"},s={class:"no-print tw-my-4 tw-text-md"},u={class:"tw-mb-4 tw-border-dashed tw-border-2 tw-border-light-blue dark:border-gray-500 tw-p-4 tw-rounded-lg tw-text-center tw-bg-gray-50 dark:bg-gray-700"},d={class:"tw-text-xl tw-text-black"},f={class:"tw-bg-gray-100 tw-text-gray-800 tw-text-xs tw-font-semibold tw-mr-2 tw-px-2.5 tw-py-0.5 tw-rounded"},p={class:"tw-my-4 tw-text-md"},h=["placeholder"],m={class:"tw-flex tw-justify-center tw-items-center"},v=["src"],w=["innerHTML"];const g={props:["status","qr_url","recovery","svg"],data:function(){return{form:{},loading:!1}},methods:{confirmOtp:function(){Nova.request().post("/nova-vendor/nova-two-factor/confirm",this.form).then((function(t){Nova.success(t.data.message),Nova.visit(t.data.url)})).catch((function(t){Nova.error(t.response.data.message)}))},autoSubmit:function(){6===this.form.otp.length&&this.confirmOtp()},downloadAsText:function(t,e){var r=document.createElement("a");r.setAttribute("href","data:text/plain;charset=utf-8,"+encodeURIComponent(e)),r.setAttribute("download",t),r.style.display="none",document.body.appendChild(r),r.click(),document.body.removeChild(r)}},computed:{}};var y=r(262);const b=(0,y.A)(g,[["render",function(t,e,r,g,y,b){var x=(0,o.resolveComponent)("heading"),N=(0,o.resolveComponent)("InertiaButton"),_=(0,o.resolveComponent)("LoadingCard"),E=(0,o.resolveComponent)("LoadingView");return(0,o.openBlock)(),(0,o.createBlock)(E,{loading:y.loading},{default:(0,o.withCtx)((function(){return[(0,o.createVNode)(x,{class:"mb-6"},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(t.__("Two factor auth (Google 2FA)")),1)]})),_:1}),(0,o.createVNode)(_,{loading:y.loading},{default:(0,o.withCtx)((function(){return[(0,o.createElementVNode)("div",n,[(0,o.createElementVNode)("div",a,[(0,o.createElementVNode)("p",null,(0,o.toDisplayString)(t.__("Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as\n            factors) to verify your identity. Two factor authentication protects against phishing, social engineering\n            and password brute force attacks and secures your logins from attackers exploiting weak or stolen\n            credentials.")),1),(0,o.createElementVNode)("h3",i,(0,o.toDisplayString)(t.__("Recovery codes")),1),(0,o.createElementVNode)("p",c,(0,o.toDisplayString)(t.__("Recovery code are used to access your account in the event you cannot receive two-factor authentication\n            codes.")),1),(0,o.createElementVNode)("span",l,(0,o.toDisplayString)(t.__("Step 01")),1),(0,o.createElementVNode)("p",s,(0,o.toDisplayString)(t.__("Download, print or copy your recovery code before continuing two-factor authentication setup.")),1),(0,o.createElementVNode)("div",u,[(0,o.createElementVNode)("h2",d,(0,o.toDisplayString)(r.recovery),1),(0,o.createElementVNode)("a",{class:"tw-text-blue-700",onClick:e[0]||(e[0]=(0,o.withModifiers)((function(t){return b.downloadAsText("recover_code.txt",r.recovery)}),["prevent"])),href:"#"},(0,o.toDisplayString)(t.__("Download")),1)]),(0,o.createElementVNode)("span",f,(0,o.toDisplayString)(t.__("Step 02")),1),(0,o.createElementVNode)("div",p,[(0,o.createTextVNode)((0,o.toDisplayString)(t.__("Scan this QR code using Google authenticator to setup & enter OTP to activate 2FA"))+" ",1),e[3]||(e[3]=(0,o.createElementVNode)("br",null,null,-1)),(0,o.withDirectives)((0,o.createElementVNode)("input",{"onUpdate:modelValue":e[1]||(e[1]=function(t){return y.form.otp=t}),onKeyup:e[2]||(e[2]=function(t){return b.autoSubmit()}),placeholder:t.__("Enter OTP here"),type:"text",class:"form-control form-input form-control-bordered"},null,40,h),[[o.vModelText,y.form.otp]]),e[4]||(e[4]=(0,o.createElementVNode)("br",null,null,-1)),(0,o.createVNode)(N,{disabled:y.loading,onClick:b.confirmOtp,class:"btn btn-default btn-primary mt-4"},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(t.__("Activate 2FA")),1)]})),_:1},8,["disabled","onClick"])])]),(0,o.createElementVNode)("div",m,[(0,o.createElementVNode)("div",null,[r.svg?((0,o.openBlock)(),(0,o.createElementBlock)("div",{key:1,innerHTML:r.qr_url},null,8,w)):((0,o.openBlock)(),(0,o.createElementBlock)("img",{key:0,width:"250",height:"250",src:r.qr_url,alt:"qr_code",class:"tw-shadow-md tw-p-5 tw-rounded-lg"},null,8,v))])])])]})),_:1},8,["loading"])]})),_:1},8,["loading"])}]]);var x={class:"tw-grid tw-grid-cols-2 tw-gap-4 p-4"},N={class:""},_={class:"mb-4 text-slate-900 dark:text-slate-400"},E={class:"tw-flex tw-items-center tw-mb-4"},V={for:"op-enable",class:"tw-block tw-ml-2 tw-text-sm tw-font-medium dark:text-white"},k={class:"tw-flex tw-items-center tw-mb-4"},C={for:"op-disable",class:"tw-block tw-ml-2 tw-text-sm tw-font-medium dark:text-white"};const S={props:["enabled"],data:function(){return{loading:!1,status:this.enabled}},mounted:function(){},methods:{toggle:function(){Nova.request().post("/nova-vendor/nova-two-factor/toggle",{status:this.status}).then((function(t){Nova.success(t.data.message)}))},resolveNovaPath:function(t){return Nova.url(t)}},computed:{}},T=(0,y.A)(S,[["render",function(t,e,r,n,a,i){var c=(0,o.resolveComponent)("heading"),l=(0,o.resolveComponent)("InertiaButton"),s=(0,o.resolveComponent)("Link"),u=(0,o.resolveComponent)("LoadingCard"),d=(0,o.resolveComponent)("LoadingView");return(0,o.openBlock)(),(0,o.createBlock)(d,{loading:a.loading},{default:(0,o.withCtx)((function(){return[(0,o.createVNode)(c,{class:"mb-6"},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(t.__("Two factor auth (Google 2FA)")),1)]})),_:1}),(0,o.createVNode)(u,{loading:a.loading},{default:(0,o.withCtx)((function(){return[(0,o.createElementVNode)("div",x,[(0,o.createElementVNode)("div",N,[(0,o.createElementVNode)("div",null,[(0,o.createElementVNode)("p",_,(0,o.toDisplayString)(t.__("Update your two factor security settings")),1),(0,o.createElementVNode)("div",E,[(0,o.withDirectives)((0,o.createElementVNode)("input",{"onUpdate:modelValue":e[0]||(e[0]=function(t){return a.status=t}),value:!0,id:"op-enable",type:"radio",class:"tw-w-4 tw-h-4 tw-border-gray-300 tw-focus:ring-2 tw-focus:ring-blue-300"},null,512),[[o.vModelRadio,a.status]]),(0,o.createElementVNode)("label",V,(0,o.toDisplayString)(t.__("Enable")),1)]),(0,o.createElementVNode)("div",k,[(0,o.withDirectives)((0,o.createElementVNode)("input",{"onUpdate:modelValue":e[1]||(e[1]=function(t){return a.status=t}),value:!1,id:"op-disable",type:"radio",class:"tw-w-4 tw-h-4 tw-border-gray-300 tw-focus:ring-2 tw-focus:ring-blue-300"},null,512),[[o.vModelRadio,a.status]]),(0,o.createElementVNode)("label",C,(0,o.toDisplayString)(t.__("Disable")),1)]),e[2]||(e[2]=(0,o.createElementVNode)("br",null,null,-1)),(0,o.createVNode)(l,{onClick:i.toggle},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(t.__("Update Settings")),1)]})),_:1},8,["onClick"]),(0,o.createVNode)(s,{class:"ml-3",as:"button",href:i.resolveNovaPath("/nova-two-factor/clear")},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(t.__("Clear settings")),1)]})),_:1},8,["href"])])])])]})),_:1},8,["loading"])]})),_:1},8,["loading"])}]]);var L={class:"text-2xl text-center font-normal mb-6 text-90"},D={class:"mb-6"},O={class:"block mb-2",for:"otp"};const A={props:["referer"],data:function(){return{otp:"",error:null}},mounted:function(){var t=this;this.$nextTick((function(){return t.$refs.otp.focus()}))},methods:{auth:function(){var t=this,e=this;Nova.request().post("/nova-vendor/nova-two-factor/validatePrompt",{one_time_password:this.otp}).then((function(t){window.location.href=e.referer})).catch((function(e){t.error=e.response.data.message}))},autoSubmit:function(){6===this.otp.length&&this.auth()}}},B=(0,y.A)(A,[["render",function(t,e,r,n,a,i){var c=(0,o.resolveComponent)("DividerLine"),l=(0,o.resolveComponent)("HelpText"),s=(0,o.resolveComponent)("InertiaButton");return(0,o.openBlock)(),(0,o.createElementBlock)("div",null,[(0,o.createElementVNode)("form",{onSubmit:e[2]||(e[2]=(0,o.withModifiers)((function(t){return i.auth()}),["prevent"])),class:"bg-white dark:bg-gray-800 shadow rounded-lg p-8 max-w-[25rem] mx-auto"},[(0,o.createElementVNode)("h2",L,(0,o.toDisplayString)(t.__("Two factor authentication")),1),(0,o.createVNode)(c),(0,o.createElementVNode)("div",D,[(0,o.createElementVNode)("label",O,(0,o.toDisplayString)(t.__("One time password")),1),(0,o.withDirectives)((0,o.createElementVNode)("input",{"onUpdate:modelValue":e[0]||(e[0]=function(t){return a.otp=t}),onKeyup:e[1]||(e[1]=function(t){return i.autoSubmit()}),class:"form-control form-input form-control-bordered w-full",maxLength:"6",id:"otp",type:"text",name:"otp",ref:"otp",autofocus:"",required:""},null,544),[[o.vModelText,a.otp]]),a.error?((0,o.openBlock)(),(0,o.createBlock)(l,{key:0,class:"mt-2 text-red-500"},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(a.error),1)]})),_:1})):(0,o.createCommentVNode)("",!0)]),(0,o.createVNode)(s,{class:"w-full flex justify-center",type:"submit"},{default:(0,o.withCtx)((function(){return[(0,o.createElementVNode)("span",null,(0,o.toDisplayString)(t.__("Authenticate")),1)]})),_:1})],32)])}]]);var j={class:"p-4"},F={class:"mb-3"},P={class:"mb-6"},G={class:"block mb-2",for:"password"},q={class:"shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm",type:"submit"};function M(t){return M="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},M(t)}function U(){U=function(){return e};var t,e={},r=Object.prototype,o=r.hasOwnProperty,n=Object.defineProperty||function(t,e,r){t[e]=r.value},a="function"==typeof Symbol?Symbol:{},i=a.iterator||"@@iterator",c=a.asyncIterator||"@@asyncIterator",l=a.toStringTag||"@@toStringTag";function s(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{s({},"")}catch(t){s=function(t,e,r){return t[e]=r}}function u(t,e,r,o){var a=e&&e.prototype instanceof w?e:w,i=Object.create(a.prototype),c=new L(o||[]);return n(i,"_invoke",{value:k(t,r,c)}),i}function d(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}e.wrap=u;var f="suspendedStart",p="suspendedYield",h="executing",m="completed",v={};function w(){}function g(){}function y(){}var b={};s(b,i,(function(){return this}));var x=Object.getPrototypeOf,N=x&&x(x(D([])));N&&N!==r&&o.call(N,i)&&(b=N);var _=y.prototype=w.prototype=Object.create(b);function E(t){["next","throw","return"].forEach((function(e){s(t,e,(function(t){return this._invoke(e,t)}))}))}function V(t,e){function r(n,a,i,c){var l=d(t[n],t,a);if("throw"!==l.type){var s=l.arg,u=s.value;return u&&"object"==M(u)&&o.call(u,"__await")?e.resolve(u.__await).then((function(t){r("next",t,i,c)}),(function(t){r("throw",t,i,c)})):e.resolve(u).then((function(t){s.value=t,i(s)}),(function(t){return r("throw",t,i,c)}))}c(l.arg)}var a;n(this,"_invoke",{value:function(t,o){function n(){return new e((function(e,n){r(t,o,e,n)}))}return a=a?a.then(n,n):n()}})}function k(e,r,o){var n=f;return function(a,i){if(n===h)throw Error("Generator is already running");if(n===m){if("throw"===a)throw i;return{value:t,done:!0}}for(o.method=a,o.arg=i;;){var c=o.delegate;if(c){var l=C(c,o);if(l){if(l===v)continue;return l}}if("next"===o.method)o.sent=o._sent=o.arg;else if("throw"===o.method){if(n===f)throw n=m,o.arg;o.dispatchException(o.arg)}else"return"===o.method&&o.abrupt("return",o.arg);n=h;var s=d(e,r,o);if("normal"===s.type){if(n=o.done?m:p,s.arg===v)continue;return{value:s.arg,done:o.done}}"throw"===s.type&&(n=m,o.method="throw",o.arg=s.arg)}}}function C(e,r){var o=r.method,n=e.iterator[o];if(n===t)return r.delegate=null,"throw"===o&&e.iterator.return&&(r.method="return",r.arg=t,C(e,r),"throw"===r.method)||"return"!==o&&(r.method="throw",r.arg=new TypeError("The iterator does not provide a '"+o+"' method")),v;var a=d(n,e.iterator,r.arg);if("throw"===a.type)return r.method="throw",r.arg=a.arg,r.delegate=null,v;var i=a.arg;return i?i.done?(r[e.resultName]=i.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=t),r.delegate=null,v):i:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,v)}function S(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function T(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function L(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(S,this),this.reset(!0)}function D(e){if(e||""===e){var r=e[i];if(r)return r.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var n=-1,a=function r(){for(;++n<e.length;)if(o.call(e,n))return r.value=e[n],r.done=!1,r;return r.value=t,r.done=!0,r};return a.next=a}}throw new TypeError(M(e)+" is not iterable")}return g.prototype=y,n(_,"constructor",{value:y,configurable:!0}),n(y,"constructor",{value:g,configurable:!0}),g.displayName=s(y,l,"GeneratorFunction"),e.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===g||"GeneratorFunction"===(e.displayName||e.name))},e.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,y):(t.__proto__=y,s(t,l,"GeneratorFunction")),t.prototype=Object.create(_),t},e.awrap=function(t){return{__await:t}},E(V.prototype),s(V.prototype,c,(function(){return this})),e.AsyncIterator=V,e.async=function(t,r,o,n,a){void 0===a&&(a=Promise);var i=new V(u(t,r,o,n),a);return e.isGeneratorFunction(r)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},E(_),s(_,l,"Generator"),s(_,i,(function(){return this})),s(_,"toString",(function(){return"[object Generator]"})),e.keys=function(t){var e=Object(t),r=[];for(var o in e)r.push(o);return r.reverse(),function t(){for(;r.length;){var o=r.pop();if(o in e)return t.value=o,t.done=!1,t}return t.done=!0,t}},e.values=D,L.prototype={constructor:L,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=t,this.done=!1,this.delegate=null,this.method="next",this.arg=t,this.tryEntries.forEach(T),!e)for(var r in this)"t"===r.charAt(0)&&o.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=t)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var r=this;function n(o,n){return c.type="throw",c.arg=e,r.next=o,n&&(r.method="next",r.arg=t),!!n}for(var a=this.tryEntries.length-1;a>=0;--a){var i=this.tryEntries[a],c=i.completion;if("root"===i.tryLoc)return n("end");if(i.tryLoc<=this.prev){var l=o.call(i,"catchLoc"),s=o.call(i,"finallyLoc");if(l&&s){if(this.prev<i.catchLoc)return n(i.catchLoc,!0);if(this.prev<i.finallyLoc)return n(i.finallyLoc)}else if(l){if(this.prev<i.catchLoc)return n(i.catchLoc,!0)}else{if(!s)throw Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return n(i.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&o.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var a=n;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=e&&e<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=t,i.arg=e,a?(this.method="next",this.next=a.finallyLoc,v):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),v},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),T(r),v}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var o=r.completion;if("throw"===o.type){var n=o.arg;T(r)}return n}}throw Error("illegal catch attempt")},delegateYield:function(e,r,o){return this.delegate={iterator:D(e),resultName:r,nextLoc:o},"next"===this.method&&(this.arg=t),v}},e}function I(t,e,r,o,n,a,i){try{var c=t[a](i),l=c.value}catch(t){return void r(t)}c.done?e(l):Promise.resolve(l).then(o,n)}const R={data:function(){return{form:Nova.form({password:null})}},mounted:function(){var t=this;this.$nextTick((function(){return t.$refs.password.focus()}))},methods:{auth:function(){var t,e=this;return(t=U().mark((function t(){var r,o;return U().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.form.post("/nova-vendor/nova-two-factor/clear");case 2:r=t.sent,o=r.message,Nova.success(o),Nova.visit("/nova-two-factor");case 6:case"end":return t.stop()}}),t)})),function(){var e=this,r=arguments;return new Promise((function(o,n){var a=t.apply(e,r);function i(t){I(a,o,n,i,c,"next",t)}function c(t){I(a,o,n,i,c,"throw",t)}i(void 0)}))})()}}},H=(0,y.A)(R,[["render",function(t,e,r,n,a,i){var c=(0,o.resolveComponent)("heading"),l=(0,o.resolveComponent)("HelpText"),s=(0,o.resolveComponent)("Card"),u=(0,o.resolveComponent)("LoadingView");return(0,o.openBlock)(),(0,o.createBlock)(u,{loading:!1},{default:(0,o.withCtx)((function(){return[(0,o.createVNode)(c,{class:"mb-6"},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(t.__("Two factor auth (Google 2FA)")),1)]})),_:1}),(0,o.createVNode)(s,null,{default:(0,o.withCtx)((function(){return[(0,o.createElementVNode)("div",j,[(0,o.createElementVNode)("p",F,(0,o.toDisplayString)(t.__("By clearing these settings you can re-register Two FA on your device")),1),(0,o.createElementVNode)("form",{class:"max-w-[25rem]",onSubmit:e[1]||(e[1]=(0,o.withModifiers)((function(t){return i.auth()}),["prevent"]))},[(0,o.createElementVNode)("div",P,[(0,o.createElementVNode)("label",G,(0,o.toDisplayString)(t.__("Enter your password")),1),(0,o.withDirectives)((0,o.createElementVNode)("input",{"onUpdate:modelValue":e[0]||(e[0]=function(t){return a.form.password=t}),class:"form-control form-input form-control-bordered w-full",id:"password",type:"password",name:"password",ref:"password",autofocus:"",required:""},null,512),[[o.vModelText,a.form.password]]),a.form.errors.has("password")?((0,o.openBlock)(),(0,o.createBlock)(l,{key:0,class:"mt-2 text-red-700"},{default:(0,o.withCtx)((function(){return[(0,o.createTextVNode)((0,o.toDisplayString)(a.form.errors.first("password")),1)]})),_:1})):(0,o.createCommentVNode)("",!0)]),(0,o.createElementVNode)("button",q,[(0,o.createElementVNode)("span",null,(0,o.toDisplayString)(t.__("Clear")),1)])],32)])]})),_:1})]})),_:1})}]]);Nova.booting((function(t,e){Nova.inertia("NovaTwoFactor.Register",b),Nova.inertia("NovaTwoFactor.Settings",T),Nova.inertia("NovaTwoFactor.Prompt",B),Nova.inertia("NovaTwoFactor.Clear",H)}))},550:()=>{},262:(t,e)=>{e.A=(t,e)=>{const r=t.__vccOpts||t;for(const[t,o]of e)r[t]=o;return r}}},r={};function o(t){var n=r[t];if(void 0!==n)return n.exports;var a=r[t]={exports:{}};return e[t](a,a.exports,o),a.exports}o.m=e,t=[],o.O=(e,r,n,a)=>{if(!r){var i=1/0;for(u=0;u<t.length;u++){for(var[r,n,a]=t[u],c=!0,l=0;l<r.length;l++)(!1&a||i>=a)&&Object.keys(o.O).every((t=>o.O[t](r[l])))?r.splice(l--,1):(c=!1,a<i&&(i=a));if(c){t.splice(u--,1);var s=n();void 0!==s&&(e=s)}}return e}a=a||0;for(var u=t.length;u>0&&t[u-1][2]>a;u--)t[u]=t[u-1];t[u]=[r,n,a]},o.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),(()=>{var t={416:0,757:0};o.O.j=e=>0===t[e];var e=(e,r)=>{var n,a,[i,c,l]=r,s=0;if(i.some((e=>0!==t[e]))){for(n in c)o.o(c,n)&&(o.m[n]=c[n]);if(l)var u=l(o)}for(e&&e(r);s<i.length;s++)a=i[s],o.o(t,a)&&t[a]&&t[a][0](),t[a]=0;return o.O(u)},r=self.webpackChunkvisanduma_nova_two_factor=self.webpackChunkvisanduma_nova_two_factor||[];r.forEach(e.bind(null,0)),r.push=e.bind(null,r.push.bind(r))})(),o.O(void 0,[757],(()=>o(551)));var n=o.O(void 0,[757],(()=>o(550)));n=o.O(n)})();