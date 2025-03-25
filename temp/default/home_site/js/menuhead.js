function toggleMenu(event, menuId) {
  event.preventDefault();

  // Lấy menu cần xử lý
  const menu = document.getElementById(menuId);
  const button = event.target; // Nút được click
  const isVisible = menu.style.display === "block";

  // Đóng tất cả các menu khác trước khi xử lý menu được click
  document.querySelectorAll(".dropdown-menu-custom").forEach((otherMenu) => {
    if (otherMenu !== menu) {
      otherMenu.style.display = "none";
    }
  });

  if (!isVisible) {
    // Lấy tọa độ và kích thước của nút
    const buttonRect = button.getBoundingClientRect();

    // Đặt vị trí menu
    menu.style.top = `${buttonRect.bottom + 4}px`; // Hiển thị ngay bên dưới nút
    menu.style.left = `${buttonRect.left + buttonRect.width / 2}px`; // Căn giữa theo nút
    menu.style.transform = "translateX(-50%)"; // Căn chỉnh ngang
    menu.style.display = "block";

    // Thêm sự kiện click ra bên ngoài
    document.addEventListener("click", closeMenuOnOutsideClick);
  } else {
    // Ẩn menu nếu đã hiển thị
    menu.style.display = "none";
  }

  // Hàm xử lý ẩn menu khi click ra bên ngoài
  function closeMenuOnOutsideClick(event) {
    const menus = document.querySelectorAll(".dropdown-menu-custom");
    let clickedInside = false;

    menus.forEach((menu) => {
      if (menu.contains(event.target) || event.target === button) {
        clickedInside = true; // Kiểm tra nếu click vào menu hoặc nút
      }
    });

    if (!clickedInside) {
      menus.forEach((menu) => (menu.style.display = "none")); // Ẩn tất cả các menu
      document.removeEventListener("click", closeMenuOnOutsideClick); // Gỡ sự kiện
    }
  }
}

// Thêm hiệu ứng hover cho từng menu
document.querySelectorAll(".dropdown-menu-custom a").forEach((link) => {
  link.addEventListener("mouseover", (e) => {
    // Kiểm tra menu cha để áp dụng hiệu ứng màu phù hợp
    const parentMenu = e.target.closest(".dropdown-menu-custom");

    parentMenu.querySelectorAll("a").forEach((item) => {
      item.style.boxShadow = "none"; // Xóa thuộc tính box-shadow mặc định
      item.style.border = "none"; // Xóa border mặc định
    });

    if (parentMenu.id === "loginMenu") {
      e.target.style.boxShadow = "2px 3px 5px 1px #da9936bd";
      e.target.style.border = "2px solid #da9936ba";
    } else if (parentMenu.id === "signupMenu") {
      e.target.style.boxShadow = "2px 3px 5px 1px #0704bda6";
      e.target.style.border = "2px solid #0704bd";
    }
  });

  link.addEventListener("mouseout", () => {
    // Khôi phục box-shadow mặc định cho tất cả các thẻ <a> trong menu cha
    const parentMenu = link.closest(".dropdown-menu-custom");
    parentMenu.querySelectorAll("a").forEach((item) => {
      item.style.boxShadow = "0px 3px 3px 1px #f1f1f1";
      item.style.border = "none"; // Xóa border sau khi hover
    });
  });
});
