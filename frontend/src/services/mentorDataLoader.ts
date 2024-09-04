import { retrieveMentors } from '@/services/api';
import { ref, toRaw } from 'vue';

const itemsPerPage = ref<number>(5);
const serverItems = ref([]);
const totalItems = ref<number>(0);
const loading = ref<boolean>(false);

async function loadItems({ page, sortBy, search }: any) {
  loading.value = true;
  let query = `?per_page=${itemsPerPage.value}&page=${page}`;
  const rawSort = toRaw(sortBy);

  if (search) {
    query += `&searchBy=${search}`;
  }

  if (rawSort.length > 0) {
    query += `&sortBy=${rawSort[0].key}&orderBy=${rawSort[0].order}`;
  }

  const response = await retrieveMentors(query);
  totalItems.value = response.data.paginate.total;
  serverItems.value = response.data.paginate.data;
  loading.value = false;
}

export { loadItems, itemsPerPage, serverItems, totalItems, loading };
