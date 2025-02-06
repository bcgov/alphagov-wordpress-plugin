(()=>{"use strict";var e,t={710:()=>{const e=window.wp.blocks,t=window.wp.components,n=window.wp.i18n,s=window.wp.element,a=window.wp.data,r=window.wp.blockEditor,o=window.wp.coreData,i=window.ReactJSXRuntime;function l(){return(0,i.jsxs)("button",{className:"dswp-nav-mobile-toggle-icon","aria-label":"Toggle menu","aria-expanded":"false",children:[(0,i.jsx)("span",{className:"dswp-nav-mobile-menu-icon-text",children:"Menu"}),(0,i.jsxs)("svg",{width:"24",height:"24",viewBox:"0 0 24 24","aria-hidden":"true",focusable:"false",children:[(0,i.jsx)("path",{className:"dswp-nav-mobile-bar dswp-nav-mobile-menu-top-bar",d:"M3,6h13",strokeWidth:"1",stroke:"currentColor"}),(0,i.jsx)("path",{className:"dswp-nav-mobile-bar dswp-nav-mobile-menu-middle-bar",d:"M3,12h13",strokeWidth:"1",stroke:"currentColor"}),(0,i.jsx)("path",{className:"dswp-nav-mobile-bar dswp-nav-mobile-menu-bottom-bar",d:"M3,18h13",strokeWidth:"1",stroke:"currentColor"})]})]})}const c=["core/navigation-link","core/navigation-submenu","core/spacer"];(0,n.__)("Add link","dswp");const u=JSON.parse('{"UU":"design-system-wordpress-plugin/navigation"}');(0,e.registerBlockType)(u.UU,{edit:function({attributes:u,setAttributes:d,clientId:p}){const{menuId:b,overlayMenu:v,mobileBreakpoint:m=768}=u,{replaceInnerBlocks:w}=(0,a.useDispatch)(r.store),{editEntityRecord:h,saveEditedEntityRecord:g}=(0,a.useDispatch)(o.store),k=(0,a.useRegistry)(),_=(0,r.useBlockProps)({className:`dswp-block-navigation-is-${v}-overlay`,"data-dswp-mobile-breakpoint":m}),{menus:y,hasResolvedMenus:x,selectedMenu:f,currentBlocks:j,isCurrentPostSaving:B}=(0,a.useSelect)((e=>{const{getEntityRecords:t,hasFinishedResolution:n,getEditedEntityRecord:s}=e(o.store),a={per_page:-1,status:["publish","draft"]};return{menus:t("postType","wp_navigation",a),hasResolvedMenus:n("getEntityRecords",["postType","wp_navigation",a]),selectedMenu:b?s("postType","wp_navigation",b):null,currentBlocks:e(r.store).getBlocks(p),isCurrentPostSaving:e("core/editor")?.isSavingPost()}}),[b,p]),N=(0,s.useRef)(null),M=(0,s.useRef)(!0),C=(0,s.useRef)(null),R=(0,s.useCallback)((t=>t.map((t=>{const n={...t.attributes,label:t.attributes.label,url:t.attributes.url,type:t.attributes.type,id:t.attributes.id,kind:t.attributes.kind,opensInNewTab:t.attributes.opensInNewTab||!1};return"core/navigation-link"===t.name?(0,e.createBlock)("core/navigation-link",n):"core/navigation-submenu"===t.name?(0,e.createBlock)("core/navigation-submenu",n,t.innerBlocks?R(t.innerBlocks):[]):null})).filter(Boolean)),[]);(0,s.useEffect)((()=>{if(f?.content&&M.current){const t=(0,e.parse)(f.content);C.current=(0,e.serialize)(t),N.current=C.current,k.dispatch(r.store).__unstableMarkNextChangeAsNotPersistent()}}),[f]),(0,s.useEffect)((()=>{!M.current&&j&&(0,e.serialize)(j)===C.current&&k.dispatch(r.store).__unstableMarkNextChangeAsNotPersistent()}),[j]),(0,s.useEffect)((()=>{if(!B||!b||!j)return;const t=(0,e.serialize)(j);t===N.current||M.current&&t===C.current||(N.current=t,(async()=>{try{await h("postType","wp_navigation",b,{content:t,status:"publish"}),await g("postType","wp_navigation",b)}catch(e){console.error("Failed to update navigation menu:",e)}})())}),[B,b,j,h,g]),(0,s.useEffect)((()=>{if(!f||!f.content)return k.dispatch(r.store).__unstableMarkNextChangeAsNotPersistent(),w(p,[]),N.current=(0,e.serialize)([]),void(M.current=!1);const t=(0,e.parse)(f.content),n=R(t);k.dispatch(r.store).__unstableMarkNextChangeAsNotPersistent(),w(p,n),M.current&&(N.current=(0,e.serialize)(n),C.current=N.current,M.current=!1,k.dispatch(r.store).__unstableMarkNextChangeAsNotPersistent())}),[f,k,p,R,w]);const P=(0,s.useMemo)((()=>y?.length?[{label:(0,n.__)("Select a menu","dswp"),value:0},...y.map((e=>({label:e.title.rendered||(0,n.__)("(no title)","dswp"),value:e.id})))]:[{label:(0,n.__)("Select a menu","dswp"),value:0}]),[y]),E=(0,r.useInnerBlocksProps)({className:"dswp-block-navigation__container"},{allowedBlocks:c,orientation:"horizontal",templateLock:!1});return x?(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(r.InspectorControls,{children:(0,i.jsxs)(t.PanelBody,{title:(0,n.__)("Navigation Settings","dswp"),children:[(0,i.jsx)(t.SelectControl,{label:(0,n.__)("Select Menu","dswp"),value:b||0,options:P,onChange:e=>{const t=parseInt(e);d({menuId:t})}}),(0,i.jsxs)(t.ButtonGroup,{children:[(0,i.jsx)("span",{className:"components-base-control__label",style:{display:"block",marginBottom:"8px"},children:(0,n.__)("Overlay Menu","dswp")}),(0,i.jsx)(t.Button,{variant:"mobile"===v?"primary":"secondary",onClick:()=>d({overlayMenu:"mobile"}),children:(0,n.__)("Mobile","dswp")}),(0,i.jsx)(t.Button,{variant:"always"===v?"primary":"secondary",onClick:()=>d({overlayMenu:"always"}),children:(0,n.__)("Always","dswp")}),(0,i.jsx)(t.Button,{variant:"never"===v?"primary":"secondary",onClick:()=>d({overlayMenu:"never"}),children:(0,n.__)("Never","dswp")})]}),"mobile"===v&&(0,i.jsx)("div",{style:{marginTop:"1rem"},children:(0,i.jsx)(t.RangeControl,{label:(0,n.__)("Mobile Breakpoint (px)","dswp"),value:m,onChange:e=>d({mobileBreakpoint:e}),min:320,max:1200,step:1})})]})}),(0,i.jsxs)("nav",{..._,children:[(0,i.jsx)(l,{}),(0,i.jsx)("ul",{...E})]})]}):(0,i.jsx)(t.Spinner,{})},save:function({attributes:e}){const{overlayMenu:t,mobileBreakpoint:n}=e,s=r.useBlockProps.save({className:`dswp-block-navigation-is-${t}-overlay`,"data-dswp-mobile-breakpoint":n}),a=r.useInnerBlocksProps.save({className:"dswp-block-navigation__container"});return(0,i.jsxs)("nav",{...s,children:[(0,i.jsx)(l,{}),(0,i.jsx)("ul",{...a})]})}})}},n={};function s(e){var a=n[e];if(void 0!==a)return a.exports;var r=n[e]={exports:{}};return t[e](r,r.exports,s),r.exports}s.m=t,e=[],s.O=(t,n,a,r)=>{if(!n){var o=1/0;for(u=0;u<e.length;u++){for(var[n,a,r]=e[u],i=!0,l=0;l<n.length;l++)(!1&r||o>=r)&&Object.keys(s.O).every((e=>s.O[e](n[l])))?n.splice(l--,1):(i=!1,r<o&&(o=r));if(i){e.splice(u--,1);var c=a();void 0!==c&&(t=c)}}return t}r=r||0;for(var u=e.length;u>0&&e[u-1][2]>r;u--)e[u]=e[u-1];e[u]=[n,a,r]},s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={160:0,256:0};s.O.j=t=>0===e[t];var t=(t,n)=>{var a,r,[o,i,l]=n,c=0;if(o.some((t=>0!==e[t]))){for(a in i)s.o(i,a)&&(s.m[a]=i[a]);if(l)var u=l(s)}for(t&&t(n);c<o.length;c++)r=o[c],s.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return s.O(u)},n=globalThis.webpackChunkdesign_system_navigation_block=globalThis.webpackChunkdesign_system_navigation_block||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})();var a=s.O(void 0,[256],(()=>s(710)));a=s.O(a)})();