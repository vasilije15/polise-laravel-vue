function searchTable () {
  // eslint-disable-next-line eqeqeq
  if (this.filteredTableData.length == 0) {
    this.filteredTableData = this.tableData
  }
  this.tableData = this.filteredTableData
  Object.keys(this.filters).forEach(val => {
    // eslint-disable-next-line eqeqeq
    if (this.filters[val] == '') {
      return
    }
    this.tableData = this.tableData.filter(item => {
      // eslint-disable-next-line eqeqeq
      if (item != undefined && item != null) {
        // kreiraj varijablu koja sadrzi item
        let value = item
        // ukoliko val koji predstavlja kljuc iz fitlera sadrzi tacku,
        // to znaci da treba uci u objekat, pa se to mora raditi preko []
        // eslint-disable-next-line eqeqeq
        if (val.indexOf('.') != -1) {
          // dobijamo svaki kljuc
          const keys = val.split('.')
          // prolazimo kroz svaki kljuc i ulazimo u value kroz loop i value dobija vrijednost od kljuca
          keys.forEach(part => {
            if (value != null) {
              value = value[part]
            }
          })
        } else {
          // ako nema tacke onda samo postaje kao sto pise
          value = item[val]
        }
        return (value + '').toLowerCase().indexOf((this.filters[val] + '').toLowerCase()) > -1
      }
    })
  })
  // eslint-disable-next-line eqeqeq
  if (this.tableData.length == 0) {
    this.loadingText = 'Nema podataka'
  }
}

export {
  searchTable,
}
