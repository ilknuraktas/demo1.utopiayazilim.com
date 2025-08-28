function loadBasketDrawer()
{
  if($("#sepet-hizli-urunler").html()) return;
  $("#sepet-hizli-urunler").html('<div id="delayedLoading" style="display:none;">' + ajaxLoaderDiv() + '</div>');
  setTimeout(function() { $('#delayedLoading').show(); },1000);
  url = "page.php?act=sepet&viewPopup=1&isAjax=1";
  $.get(url, function (data) {
    sepetHTMLGuncelle(data);
  });
}
function reloadBasketDrawer()
{
  $.ajax({
    url:
      "include/mod_SepetHizli.php?getHTML=sepet&r=" + Math.random(),
    success: function (data) {
      $("#sepet-hizli-urunler").html(data);
      var elements = document.getElementsByClassName("hizli-sepet-adet-guncelle");
      for (var i = 0; i < elements.length; i++) {
          elements[i].addEventListener('click', function() { hizliSepetAdetGuncelle(this.dataset.line,this.dataset.adet); }, false);
      }

      elements = document.getElementsByClassName("hizli-sepet-satir-sil");
      for (var i = 0; i < elements.length; i++) {
          elements[i].addEventListener('click', function() { hizliSepetSatirSil(this.dataset.line,this.dataset.urunID); }, false);
      }
    },
  });

  $.ajax({
    url:
      "include/mod_SepetHizli.php?getHTML=tutar&r=" + Math.random(),
    success: function (data) {
      $("#sepet-hizli-tutar").html(data);
    },
  });
}

function Util() {}
Util.hasClass = function (el, className) {
  return el.classList.contains(className);
};
Util.addClass = function (el, className) {
  var classList = className.split(" ");
  el.classList.add(classList[0]);
  if (classList.length > 1) Util.addClass(el, classList.slice(1).join(" "));
};
Util.removeClass = function (el, className) {
  var classList = className.split(" ");
  el.classList.remove(classList[0]);
  if (classList.length > 1) Util.removeClass(el, classList.slice(1).join(" "));
};
Util.toggleClass = function (el, className, bool) {
  if (bool) Util.addClass(el, className);
  else Util.removeClass(el, className);
};
Util.setAttributes = function (el, attrs) {
  for (var key in attrs) {
    el.setAttribute(key, attrs[key]);
  }
};
Util.getChildrenByClassName = function (el, className) {
  var children = el.children,
    childrenByClass = [];
  for (var i = 0; i < children.length; i++) {
    if (Util.hasClass(children[i], className))
      childrenByClass.push(children[i]);
  }
  return childrenByClass;
};
Util.is = function (elem, selector) {
  if (selector.nodeType) {
    return elem === selector;
  }
  var qa =
      typeof selector === "string"
        ? document.querySelectorAll(selector)
        : selector,
    length = qa.length,
    returnArr = [];
  while (length--) {
    if (qa[length] === elem) {
      return true;
    }
  }
  return false;
};
Util.setHeight = function (start, to, element, duration, cb, timeFunction) {
  var change = to - start,
    currentTime = null;
  var animateHeight = function (timestamp) {
    if (!currentTime) currentTime = timestamp;
    var progress = timestamp - currentTime;
    if (progress > duration) progress = duration;
    var val = parseInt((progress / duration) * change + start);
    if (timeFunction) {
      val = Math[timeFunction](progress, start, to - start, duration);
    }
    element.style.height = val + "px";
    if (progress < duration) {
      window.requestAnimationFrame(animateHeight);
    } else {
      if (cb) cb();
    }
  };
  element.style.height = start + "px";
  window.requestAnimationFrame(animateHeight);
};
Util.scrollTo = function (final, duration, cb, scrollEl) {
  var element = scrollEl || window;
  var start = element.scrollTop || document.documentElement.scrollTop,
    currentTime = null;
  if (!scrollEl) start = window.scrollY || document.documentElement.scrollTop;
  var animateScroll = function (timestamp) {
    if (!currentTime) currentTime = timestamp;
    var progress = timestamp - currentTime;
    if (progress > duration) progress = duration;
    var val = Math.easeInOutQuad(progress, start, final - start, duration);
    element.scrollTo(0, val);
    if (progress < duration) {
      window.requestAnimationFrame(animateScroll);
    } else {
      cb && cb();
    }
  };
  window.requestAnimationFrame(animateScroll);
};
Util.moveFocus = function (element) {
  if (!element) element = document.getElementsByTagName("body")[0];
  element.focus();
  if (document.activeElement !== element) {
    element.setAttribute("tabindex", "-1");
    element.focus();
  }
};
Util.getIndexInArray = function (array, el) {
  return Array.prototype.indexOf.call(array, el);
};
Util.cssSupports = function (property, value) {
  if ("CSS" in window) {
    return CSS.supports(property, value);
  } else {
    var jsProperty = property.replace(/-([a-z])/g, function (g) {
      return g[1].toUpperCase();
    });
    return jsProperty in document.body.style;
  }
};
Util.extend = function () {
  var extended = {};
  var deep = false;
  var i = 0;
  var length = arguments.length;
  if (Object.prototype.toString.call(arguments[0]) === "[object Boolean]") {
    deep = arguments[0];
    i++;
  }
  var merge = function (obj) {
    for (var prop in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, prop)) {
        if (
          deep &&
          Object.prototype.toString.call(obj[prop]) === "[object Object]"
        ) {
          extended[prop] = extend(true, extended[prop], obj[prop]);
        } else {
          extended[prop] = obj[prop];
        }
      }
    }
  };
  for (; i < length; i++) {
    var obj = arguments[i];
    merge(obj);
  }
  return extended;
};
Util.osHasReducedMotion = function () {
  if (!window.matchMedia) return false;
  var matchMediaObj = window.matchMedia("(prefers-reduced-motion: reduce)");
  if (matchMediaObj) return matchMediaObj.matches;
  return false;
};
if (!Element.prototype.matches) {
  Element.prototype.matches =
    Element.prototype.msMatchesSelector ||
    Element.prototype.webkitMatchesSelector;
}
if (!Element.prototype.closest) {
  Element.prototype.closest = function (s) {
    var el = this;
    if (!document.documentElement.contains(el)) return null;
    do {
      if (el.matches(s)) return el;
      el = el.parentElement || el.parentNode;
    } while (el !== null && el.nodeType === 1);
    return null;
  };
}
if (typeof window.CustomEvent !== "function") {
  function CustomEvent(event, params) {
    params = params || { bubbles: false, cancelable: false, detail: undefined };
    var evt = document.createEvent("CustomEvent");
    evt.initCustomEvent(
      event,
      params.bubbles,
      params.cancelable,
      params.detail
    );
    return evt;
  }
  CustomEvent.prototype = window.Event.prototype;
  window.CustomEvent = CustomEvent;
}
Math.easeInOutQuad = function (t, b, c, d) {
  t /= d / 2;
  if (t < 1) return (c / 2) * t * t + b;
  t--;
  return (-c / 2) * (t * (t - 2) - 1) + b;
};
Math.easeInQuart = function (t, b, c, d) {
  t /= d;
  return c * t * t * t * t + b;
};
Math.easeOutQuart = function (t, b, c, d) {
  t /= d;
  t--;
  return -c * (t * t * t * t - 1) + b;
};
Math.easeInOutQuart = function (t, b, c, d) {
  t /= d / 2;
  if (t < 1) return (c / 2) * t * t * t * t + b;
  t -= 2;
  return (-c / 2) * (t * t * t * t - 2) + b;
};
Math.easeOutElastic = function (t, b, c, d) {
  var s = 1.70158;
  var p = d * 0.7;
  var a = c;
  if (t == 0) return b;
  if ((t /= d) == 1) return b + c;
  if (!p) p = d * 0.3;
  if (a < Math.abs(c)) {
    a = c;
    var s = p / 4;
  } else var s = (p / (2 * Math.PI)) * Math.asin(c / a);
  return (
    a * Math.pow(2, -10 * t) * Math.sin(((t * d - s) * (2 * Math.PI)) / p) +
    c +
    b
  );
};
(function () {
  var focusTab = document.getElementsByClassName("js-tab-focus"),
    shouldInit = false,
    outlineStyle = false,
    eventDetected = false;
  function detectClick() {
    if (focusTab.length > 0) {
      resetFocusStyle(false);
      window.addEventListener("keydown", detectTab);
    }
    window.removeEventListener("mousedown", detectClick);
    outlineStyle = false;
    eventDetected = true;
  }
  function detectTab(event) {
    if (event.keyCode !== 9) return;
    resetFocusStyle(true);
    window.removeEventListener("keydown", detectTab);
    window.addEventListener("mousedown", detectClick);
    outlineStyle = true;
  }
  function resetFocusStyle(bool) {
    var outlineStyle = bool ? "" : "none";
    for (var i = 0; i < focusTab.length; i++) {
      focusTab[i].style.setProperty("outline", outlineStyle);
    }
  }
  function initFocusTabs() {
    if (shouldInit) {
      if (eventDetected) resetFocusStyle(outlineStyle);
      return;
    }
    shouldInit = focusTab.length > 0;
    window.addEventListener("mousedown", detectClick);
  }
  initFocusTabs();
  window.addEventListener("initFocusTabs", initFocusTabs);
})();
function resetFocusTabsStyle() {
  window.dispatchEvent(new CustomEvent("initFocusTabs"));
}

// File#: _1_drawer
// Usage: codyhouse.co/license
(function () {
  var Drawer = function (element) {
    this.element = element;
    this.content = document.getElementsByClassName("js-drawer__body")[0];
    /*
    this.triggers = document.querySelectorAll(
      '[aria-controls="' + this.element.getAttribute("id") + '"]'
    );
    */
    this.triggers = document.querySelectorAll(
      '.imgSepetGoster,#imgSepetGoster'
    );
    this.firstFocusable = null;
    this.lastFocusable = null;
    this.selectedTrigger = null;
    this.isModal = Util.hasClass(this.element, "js-drawer--modal");
    this.showClass = "drawer--is-visible";
    this.preventScrollEl = this.getPreventScrollEl();
    this.initDrawer();
  };

  Drawer.prototype.getPreventScrollEl = function () {
    var scrollEl = false;
    var querySelector = this.element.getAttribute("data-drawer-prevent-scroll");
    if (querySelector) scrollEl = document.querySelector(querySelector);
    return scrollEl;
  };

  Drawer.prototype.initDrawer = function () {
    var self = this;
    //open drawer when clicking on trigger buttons
    if (this.triggers) {
      for (var i = 0; i < this.triggers.length; i++) {
        this.triggers[i].addEventListener("click", function (event) {
          loadBasketDrawer();
          event.preventDefault();
          if (Util.hasClass(self.element, self.showClass)) {
            self.closeDrawer(event.target);
            return;
          }
          self.selectedTrigger = event.target;
          self.showDrawer();
          self.initDrawerEvents();
        });
      }
    }

    // if drawer is already open -> we should initialize the drawer events
    if (Util.hasClass(this.element, this.showClass)) this.initDrawerEvents();
  };

  Drawer.prototype.showDrawer = function () {
    var self = this;
    this.content.scrollTop = 0;
    Util.addClass(this.element, this.showClass);
    this.getFocusableElements();
    Util.moveFocus(this.element);
    // wait for the end of transitions before moving focus
    this.element.addEventListener("transitionend", function cb(event) {
      Util.moveFocus(self.element);
      self.element.removeEventListener("transitionend", cb);
    });
    this.emitDrawerEvents("drawerIsOpen", this.selectedTrigger);
    // change the overflow of the preventScrollEl
    if (this.preventScrollEl) this.preventScrollEl.style.overflow = "hidden";
  };

  Drawer.prototype.closeDrawer = function (target) {
    Util.removeClass(this.element, this.showClass);
    this.firstFocusable = null;
    this.lastFocusable = null;
    if (this.selectedTrigger) this.selectedTrigger.focus();
    //remove listeners
    this.cancelDrawerEvents();
    this.emitDrawerEvents("drawerIsClose", target);
    // change the overflow of the preventScrollEl
    if (this.preventScrollEl) this.preventScrollEl.style.overflow = "";
  };

  Drawer.prototype.initDrawerEvents = function () {
    //add event listeners
    this.element.addEventListener("keydown", this);
    this.element.addEventListener("click", this);
  };

  Drawer.prototype.cancelDrawerEvents = function () {
    //remove event listeners
    this.element.removeEventListener("keydown", this);
    this.element.removeEventListener("click", this);
  };

  Drawer.prototype.handleEvent = function (event) {
    switch (event.type) {
      case "click": {
        this.initClick(event);
      }
      case "keydown": {
        this.initKeyDown(event);
      }
    }
  };

  Drawer.prototype.initKeyDown = function (event) {
    if (
      (event.keyCode && event.keyCode == 27) ||
      (event.key && event.key == "Escape")
    ) {
      //close drawer window on esc
      this.closeDrawer(false);
    } else if (
      this.isModal &&
      ((event.keyCode && event.keyCode == 9) ||
        (event.key && event.key == "Tab"))
    ) {
      //trap focus inside drawer
      this.trapFocus(event);
    }
  };

  Drawer.prototype.initClick = function (event) {
    //close drawer when clicking on close button or drawer bg layer
    if (
      !event.target.closest(".js-drawer__close") &&
      !Util.hasClass(event.target, "js-drawer")
    )
      return;
    event.preventDefault();
    this.closeDrawer(event.target);
  };

  Drawer.prototype.trapFocus = function (event) {
    if (this.firstFocusable == document.activeElement && event.shiftKey) {
      //on Shift+Tab -> focus last focusable element when focus moves out of drawer
      event.preventDefault();
      this.lastFocusable.focus();
    }
    if (this.lastFocusable == document.activeElement && !event.shiftKey) {
      //on Tab -> focus first focusable element when focus moves out of drawer
      event.preventDefault();
      this.firstFocusable.focus();
    }
  };

  Drawer.prototype.getFocusableElements = function () {
    //get all focusable elements inside the drawer
    var allFocusable = this.element.querySelectorAll(
      '[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary'
    );
    this.getFirstVisible(allFocusable);
    this.getLastVisible(allFocusable);
  };

  Drawer.prototype.getFirstVisible = function (elements) {
    //get first visible focusable element inside the drawer
    for (var i = 0; i < elements.length; i++) {
      if (
        elements[i].offsetWidth ||
        elements[i].offsetHeight ||
        elements[i].getClientRects().length
      ) {
        this.firstFocusable = elements[i];
        return true;
      }
    }
  };

  Drawer.prototype.getLastVisible = function (elements) {
    //get last visible focusable element inside the drawer
    for (var i = elements.length - 1; i >= 0; i--) {
      if (
        elements[i].offsetWidth ||
        elements[i].offsetHeight ||
        elements[i].getClientRects().length
      ) {
        this.lastFocusable = elements[i];
        return true;
      }
    }
  };

  Drawer.prototype.emitDrawerEvents = function (eventName, target) {
    var event = new CustomEvent(eventName, { detail: target });
    this.element.dispatchEvent(event);
  };

  window.Drawer = Drawer;

  //initialize the Drawer objects
  var drawer = document.getElementsByClassName("js-drawer");
  if (drawer.length > 0) {
    for (var i = 0; i < drawer.length; i++) {
      (function (i) {
        new Drawer(drawer[i]);
      })(i);
    }
  }
})();

var hizliSepetSatirSil = function(lineID,urunID) {
  url =
    "page.php?act=sepet&op=sil&lineID=" +
    lineID +
    "&urunID=" +
    urunID +
    "&viewPopup=1&isAjax=1";
  $.get(url, function (data) {
    sepetHTMLGuncelle(data);
  });
};

var hizliSepetAdetGuncelle = function(lineID,adet) {
  url =
    "page.php?act=sepet&op=guncelle&lineID=" +
    lineID +
    "&adet=" +
    adet +
    "&viewPopup=1&isAjax=1";
  $.get(url, function (data) {
    sepetHTMLGuncelle(data);
  });
};
