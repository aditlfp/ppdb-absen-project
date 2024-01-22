

<script>
function paginate(meta) {
  const container = $('<div/>').addClass('join shadow-md');

  const prev = meta.links[0].url;
  const next = meta.links[meta.links.length - 1].url;
  const current = meta.current_page;

  if (prev) {
    const prevLink = $('<a/>')
      .attr('href', prev)
      .addClass('join-item btn bg-blue-600 hover:bg-blue-800')
      .text('«');

    container.append(prevLink);
  }

  const currentButton = $('<button/>')
    .addClass('join-item btn bg-blue-600 hover:bg-blue-800')
    .text(current);

  container.append(currentButton);

  if (next) {
    const nextLink = $('<a/>')
      .attr('href', next)
      .addClass('join-item btn bg-blue-600 hover:bg-blue-800')
      .text('»');

    container.append(nextLink);
  }

  // Append the container to your desired element in the DOM
  $('#paginationContainer').empty().append(container);
}
</script>