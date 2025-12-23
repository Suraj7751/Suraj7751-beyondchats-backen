import { useEffect, useState } from "react";

function App() {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(import.meta.env.VITE_API_URL)
      .then((res) => res.json())
      .then((data) => {
        setArticles(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("API Error:", err);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <h2 style={{ textAlign: "center" }}>Loading articles...</h2>;
  }

  return (
    <div style={{ padding: "20px", maxWidth: "900px", margin: "auto" }}>
      <h1>BeyondChats Articles</h1>

      {articles.length === 0 && <p>No articles found.</p>}

      {articles.map((article) => (
        <div
          key={article.id}
          style={{
            border: "1px solid #ddd",
            padding: "15px",
            marginBottom: "15px",
            borderRadius: "6px",
          }}
        >
          <h2>{article.title}</h2>
          <p style={{ color: "#555" }}>
            {article.content.slice(0, 200)}...
          </p>
          <small>
            Source:{" "}
            <a href={article.source_url} target="_blank">
              {article.source_url}
            </a>
          </small>
        </div>
      ))}
    </div>
  );
}

export default App;
