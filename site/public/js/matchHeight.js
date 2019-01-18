function resizeCategoryPanels() {
	$(".categorySelector").height($(".innerContainer").height());
	$(".categoryExpand").height($(".categorySelector").height());

	$(".allCategoryView").css('min-height', $(".mainCategoryAdminPanel").outerHeight());
	$(".allRepairsScroller").height($(".repairPanel").height() - "21");
}

window.addEventListener("resize", resizeCategoryPanels);

resizeCategoryPanels();
// Before first time it acts weird and this should be added
$(".allCategoryView").css('min-height', $(".mainCategoryAdminPanel").outerHeight());