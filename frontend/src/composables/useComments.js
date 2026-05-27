import { ref } from 'vue';
import http from '../services/http';
import { useAuthStore } from '../stores/authStore';

export function useComments(productId) {
  const authStore = useAuthStore();
  
  const comments = ref([]);
  const loadingComments = ref(false);
  const submittingComment = ref(false);

  const loadComments = async () => {
    loadingComments.value = true;
    try {
      const response = await http.get(`/products/${productId}/comments`);
      comments.value = response.data.data || response.data;
    } catch (err) {
      console.error("Error carregant els comentaris:", err);
    } finally {
      loadingComments.value = false;
    }
  };

  const submitComment = async (text, rating) => {
    if (!authStore.isAuthenticated) return false;
    submittingComment.value = true;
    
    try {
      await http.post(`/products/${productId}/comments`, { text, rating });
      await loadComments(); 
      return true; 
    } catch (err) {
      alert("Error enviant comentari.");
      console.error(err);
      return false;
    } finally {
      submittingComment.value = false;
    }
  };

  const deleteComment = async (commentId) => {
    if (!confirm("Segur que vols esborrar aquest comentari?")) return;
    try {
      await http.delete(`/comments/${commentId}`);
      await loadComments();
    } catch (err) {
      alert("Error: No tens permís.");
      console.error(err);
    }
  };

  const editComment = async (comment) => {
    const newText = prompt("Edita el teu comentari:", comment.text);
    if (newText === null || newText.trim() === comment.text) return;
    
    try {
      await http.put(`/comments/${comment.id}`, { text: newText });
      await loadComments();
    } catch (err) {
      alert("Error en editar.");
      console.error(err);
    }
  };

  const canEditOrDelete = (commentUserId) => {
    if (!authStore.isAuthenticated || !authStore.user) return false;
    return authStore.user.role === 'admin' || String(authStore.user.id) === String(commentUserId);
  };

  const formatDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('ca-ES');
  };

  return {
    comments,
    loadingComments,
    submittingComment,
    loadComments,
    submitComment,
    deleteComment,
    editComment,
    canEditOrDelete,
    formatDate
  };
}