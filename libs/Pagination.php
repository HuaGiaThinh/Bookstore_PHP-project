<?php
class Pagination
{

	private $totalItems;					// Tổng số phần tử
	private $totalItemsPerPage		= 1;	// Tổng số phần tử xuất hiện trên một trang
	private $pageRange				= 3;	// Số trang xuất hiện
	private $totalPage;						// Tổng số trang
	private $currentPage			= 1;	// Trang hiện tại

	public function __construct($totalItems, $pagination)
	{
		$this->totalItems			= $totalItems;
		$this->totalItemsPerPage	= $pagination['totalItemsPerPage'];

		if ($pagination['pageRange'] % 2 == 0) $pagination['pageRange'] = $pagination['pageRange'] + 1;

		$this->pageRange			= $pagination['pageRange'];
		$this->currentPage			= $pagination['currentPage'];
		$this->totalPage			= ceil($totalItems / $pagination['totalItemsPerPage']);
	}

	public function showPagination()
	{
		$paginationHTML = '';
		if ($this->totalPage > 1) {
			$start 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>';
			$prev 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>';
			if ($this->currentPage > 1) {
				$start 	= '<li class="page-item"><a class="page-link" onclick="javascript:changePage(1)" href="#"><i class="fas fa-angle-double-left"></i></a></li>';
				$prev 	= '<li class="page-item"><a class="page-link" onclick="javascript:changePage(' . ($this->currentPage - 1) . ')" href="#"><i class="fas fa-angle-left"></i></a></li>';
			}

			$next 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>';
			$end 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li>';
			if ($this->currentPage < $this->totalPage) {
				$next 	= '<li class="page-item"><a class="page-link" onclick="javascript:changePage(' . ($this->currentPage + 1) . ')" href="#"><i class="fas fa-angle-right"></i></a></li>';
				$end 	= '<li class="page-item"><a class="page-link" href="#" onclick="javascript:changePage(' . $this->totalPage . ')"><i class="fas fa-angle-double-right"></i></a></li>';
			}

			if ($this->pageRange < $this->totalPage) {
				if ($this->currentPage == 1) {
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				} else if ($this->currentPage == $this->totalPage) {
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				} else {
					$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
					$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

					if ($startPage < 1) {
						$endPage	= $endPage + 1;
						$startPage = 1;
					}

					if ($endPage > $this->totalPage) {
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			} else {
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '';
			for ($i = $startPage; $i <= $endPage; $i++) {
				$listPages .= '<li class="page-item">';
				if ($i == $this->currentPage) {
					$listPages .= '<span class="page-link" id="currentPage">' . $i . '</span>';
				} else {
					$listPages .= '<a class="page-link" href="#" onclick="javascript:changePage(' . $i . ')">' . $i . '</a>';
				}
				$listPages .= "</li>";
			}
			$paginationHTML = '<ul class="pagination m-0 float-right">' . $start . $prev . $listPages . $next . $end . '</ul>';
		}
		return $paginationHTML;
	}

	public function showPaginationBackend($link)
	{
		$paginationHTML = '';
		if ($this->totalPage > 1) {
			$start 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-double-left"></i></a></li>';
			$prev 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
			if ($this->currentPage > 1) {
				$start 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=1' . '"><i class="fa fa-angle-double-left"></i></a></li>';
				$prev 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . ($this->currentPage - 1) . '"><i class="fa fa-angle-left"></i></a></li>';
			}

			$next 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
			$end 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>';
			if ($this->currentPage < $this->totalPage) {
				$next 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . ($this->currentPage + 1) . '"><i class="fa fa-angle-right"></i></a></li>';
				$end 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . $this->totalPage . '"><i class="fa fa-angle-double-right"></i></a></li>';
			}

			if ($this->pageRange < $this->totalPage) {
				if ($this->currentPage == 1) {
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				} else if ($this->currentPage == $this->totalPage) {
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				} else {
					$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
					$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

					if ($startPage < 1) {
						$endPage	= $endPage + 1;
						$startPage = 1;
					}

					if ($endPage > $this->totalPage) {
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			} else {
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '';
			for ($i = $startPage; $i <= $endPage; $i++) {
				$listPages .= '<li class="page-item">';
				if ($i == $this->currentPage) {
					$listPages .= '<a class="page-link" id="currentPage">' . $i . '</a>';
				} else {
					$listPages .= '<a class="page-link" href="' . $link . '&page=' . $i . '">' . $i . '</a>';
				}
				$listPages .= "</li>";
			}
			$listPages .= '';

			$paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end . '</ul>';
		}
		return $paginationHTML;
	}

	public function showPaginationFrontend($link)
	{
		$paginationHTML = '';
		if ($this->totalPage > 1) {
			$start 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-double-left"></i></a></li>';
			$prev 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
			if ($this->currentPage > 1) {
				$start 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=1' . '"><i class="fa fa-angle-double-left"></i></a></li>';
				$prev 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . ($this->currentPage - 1) . '"><i class="fa fa-angle-left"></i></a></li>';
			}

			$next 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
			$end 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>';
			if ($this->currentPage < $this->totalPage) {
				$next 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . ($this->currentPage + 1) . '"><i class="fa fa-angle-right"></i></a></li>';
				$end 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . $this->totalPage . '"><i class="fa fa-angle-double-right"></i></a></li>';
			}

			if ($this->pageRange < $this->totalPage) {
				if ($this->currentPage == 1) {
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				} else if ($this->currentPage == $this->totalPage) {
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				} else {
					$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
					$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

					if ($startPage < 1) {
						$endPage	= $endPage + 1;
						$startPage = 1;
					}

					if ($endPage > $this->totalPage) {
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			} else {
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '';
			for ($i = $startPage; $i <= $endPage; $i++) {
				$listPages .= '<li class="page-item">';
				if ($i == $this->currentPage) {
					$listPages .= '<a class="page-link" id="currentPage">' . $i . '</a>';
				} else {
					$listPages .= '<a class="page-link" href="' . $link . '&page=' . $i . '">' . $i . '</a>';
				}
				$listPages .= "</li>";
			}
			$listPages .= '';

			$paginationHTML = '
				<div class="product-pagination">
					<div class="theme-paggination-block">
						<div class="container-fluid p-0">
							<div class="row">
								<div class="col-xl-6 col-md-6 col-sm-12">
									<nav aria-label="Page navigation">
										<nav>
											<ul class="pagination">
											'. $start . $prev . $listPages . $next . $end .'
											</ul>
										</nav>
									</nav>
								</div>
								<div class="col-xl-6 col-md-6 col-sm-12">
									<div class="product-search-count-bottom">
										<h5>Tất cả '.$this->totalItems.' sản phẩm</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			';
		}
		return $paginationHTML;
	}
}
?>