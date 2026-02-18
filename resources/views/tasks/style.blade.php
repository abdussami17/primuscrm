
<style>



div.dataTables_wrapper div.dataTables_filter {
    display: none;
}

    .table th.dragging { opacity: 0.6; background-color: #e9ecef; }
    .table th.drag-over { background-color: #d1ecf1; }
    .table th .drag-handle {cursor:pointer;  position: relative; left: 5px; top: 0px; color: #fff; opacity: 0.5; transition: opacity 0.2s; }
    .table th:hover .drag-handle { opacity: 1; }

    .no-sort { cursor: default !important; }
    .no-sort .drag-handle { display: none; }
    @media (max-width: 768px) { .table th { cursor: default; } .table th .drag-handle { display: none; } }
  </style>

<style>
    /* Optional: Style the dropdown input for better appearance */
    .ts-control .dropdown-input {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 6px 8px;
      margin: 5px;
      width: calc(100% - 10px);
      font-size: 14px;
    }

    .ts-control .dropdown-input:focus {
      outline: none;
      border-color: #007bff;
      box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }

    /* Ensure the main input remains non-editable */
    .ts-control input[readonly] {
      background-color: #fff;
      cursor: pointer;
    }
    </style>

  <style>
  .priority-legend  .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 0 0 rgba(0, 0, 0, 0);
        animation: none;
    }

 .priority-legend   .status-dot.overdue {
        background-color: #dc3545;
        animation: blink-red 1s infinite ease-in-out;
    }

   .priority-legend .status-dot.today {
        background-color: #fd7e14;
        animation: blink-orange 1.5s infinite ease-in-out;
    }

  .priority-legend  .status-dot.future {
        background-color: #6c757d;
        animation: blink-gray 2s infinite ease-in-out;
    }

    @keyframes blink-red {
        0%, 100% {
            box-shadow: 0 0 0px rgba(220, 53, 69, 0.3);
            opacity: 1;
        }
        50% {
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.8);
            opacity: 0.7;
        }
    }

    @keyframes blink-orange {
        0%, 100% {
            box-shadow: 0 0 0px rgba(253, 126, 20, 0.3);
            opacity: 1;
        }
        50% {
            box-shadow: 0 0 10px rgba(253, 126, 20, 0.8);
            opacity: 0.8;
        }
    }

    @keyframes blink-gray {
        0%, 100% {
            box-shadow: 0 0 0px rgba(108, 117, 125, 0.2);
            opacity: 1;
        }
        50% {
            box-shadow: 0 0 6px rgba(108, 117, 125, 0.6);
            opacity: 0.9;
        }
    }

    .priority-info-icon {
        display: inline-block;
        width: 16px;
        height: 16px;
        background-color: rgb(0, 33, 64);
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 16px;
        font-size: 11px;
        cursor: pointer;
        margin-left: 8px;
    }

    .priority-tooltip {
        position: absolute;
        background: #333;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1000;
        display: none;
        max-width: 300px;
        white-space: normal;
    }

    .tagged-user-badge {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: rgb(0, 33, 64);
        color: white;
        text-align: center;
        line-height: 32px;
        font-size: 12px;
        font-weight: bold;
        margin-right: 5px;
    }

    .note-entry {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        border-left: 3px solid rgb(0, 33, 64);
        margin-bottom: 12px;
    }





    .priority-legend-item {
        display: inline-flex;
        align-items: center;
        margin-right: 20px;
        font-size: 13px;
        color: #555;
    }

    .sort-arrow {
        cursor: pointer;
        margin-left: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    .sort-arrow:hover {
        color: rgb(0, 33, 64);
    }

    .filter-wrapper select {
        width: 100%;
    }
  </style>
